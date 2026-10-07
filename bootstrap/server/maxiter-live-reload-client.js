(function () {
    'use strict';
    if (window.__MAXITER_LIVE_RELOAD_LOADED__) return;
    window.__MAXITER_LIVE_RELOAD_LOADED__ = true;

    var host = (window.location.hostname || 'localhost');
    var httpPort = window.location.port || '80';
    var wsPort = (typeof window.__MAXITER_LIVE_RELOAD_PORT__ === 'number') ? window.__MAXITER_LIVE_RELOAD_PORT__ : null;
    var reconnectDelay = 500;
    var maxReconnectDelay = 5000;
    var attempts = 0;
    var socket = null;
    var closedByScript = false;
    var mode = null;
    var resolvingPort = false;
    var resolvedOnce = false;

    function log() {
        var args = Array.prototype.slice.call(arguments);
        args.unshift('%c[Maxiter HMR]', 'color:#00b8d4;font-weight:bold;');
        try { console.log.apply(console, args); } catch (e) {}
    }

    function overlay(msg, color) {
        try {
            var el = document.getElementById('__maxiter_hmr_overlay');
            if (!el) {
                el = document.createElement('div');
                el.id = '__maxiter_hmr_overlay';
                el.style.cssText = 'position:fixed;left:0;bottom:0;z-index:2147483647;padding:4px 10px;' +
                    'font-family:monospace;font-size:12px;color:#fff;border-top-right-radius:6px;pointer-events:none;';
                document.documentElement.appendChild(el);
            }
            el.style.background = color || '#222';
            el.textContent = msg;
        } catch (e) {}
    }

    function ensurePort(callback) {
        if (wsPort !== null) { callback(); return; }
        if (resolvingPort) return;
        resolvingPort = true;
        var req = new XMLHttpRequest();
        req.open('GET', '/__maxiter_live_port?_=' + Date.now(), true);
        req.onreadystatechange = function () {
            if (req.readyState !== 4) return;
            resolvingPort = false;
            try {
                if (req.status === 200) {
                    var data = JSON.parse(req.responseText);
                    if (data && typeof data.port === 'number' && data.port > 0) {
                        wsPort = data.port;
                        resolvedOnce = true;
                        callback();
                        return;
                    }
                }
            } catch (e) {}
            setTimeout(function () { ensurePort(callback); }, 1500);
        };
        try { req.send(null); } catch (e) { resolvingPort = false; setTimeout(function () { ensurePort(callback); }, 1500); }
    }

    function triggerReload(files) {
        files = Array.isArray(files) ? files : [];
        overlay('Reloading… ' + (files[0] || ''), '#d97706');
        log('Change detected in', files.length ? files : 'project', '→ reloading');
        closedByScript = true;
        try { if (socket && typeof socket.close === 'function') socket.close(); } catch (e) {}
        setTimeout(function () { window.location.reload(true); }, 30);
    }

    function connectWebSocket() {
        mode = 'ws';
        closedByScript = false;
        var protocol = (window.location.protocol === 'https:' ? 'wss://' : 'ws://');
        var url = protocol + host + ':' + wsPort + '/__maxiter_live';
        try {
            socket = new WebSocket(url);
        } catch (e) {
            log('WebSocket unavailable, falling back to SSE');
            connectSSE();
            return;
        }
        socket.onopen = function () {
            attempts = 0;
            reconnectDelay = 500;
            overlay('LiveReload connected (WS)', '#1f9d55');
            log('Connected to ' + url);
        };
        socket.onmessage = function (ev) {
            var msg = ev.data;
            try {
                var parsedMsg = typeof msg === 'string' ? JSON.parse(msg) : { type: msg };
                if (parsedMsg && parsedMsg.type === 'ping') {
                    try { socket.send(JSON.stringify({ type: 'pong' })); } catch (e) {}
                    return;
                }
                if (parsedMsg && parsedMsg.type === 'reload') {
                    triggerReload(parsedMsg.files);
                    return;
                }
            } catch (e) {
                if (msg === 'reload') triggerReload([]);
            }
        };
        socket.onerror = function () {
            overlay('LiveReload error (WS)', '#dc2626');
        };
        socket.onclose = function () {
            if (closedByScript) return;
            overlay('LiveReload offline — reconnecting…', '#7c3aed');
            scheduleReconnect();
        };
    }

    function connectSSE() {
        mode = 'sse';
        closedByScript = false;
        var proto = (window.location.protocol === 'https:' ? 'https://' : 'http://');
        var url = proto + host + ':' + wsPort + '/__maxiter_live';
        var EventSourceCtor = window.EventSource;
        if (!EventSourceCtor) {
            scheduleReconnect();
            return;
        }
        try {
            socket = new EventSourceCtor(url, { withCredentials: false });
        } catch (e) {
            scheduleReconnect();
            return;
        }
        socket.addEventListener('open', function () {
            attempts = 0;
            reconnectDelay = 500;
            overlay('LiveReload connected (SSE)', '#1f9d55');
            log('Connected to ' + url + ' (SSE)');
        });
        socket.addEventListener('reload', function (ev) {
            try {
                var data = JSON.parse(ev.data);
                triggerReload(data.files);
            } catch (e) {
                triggerReload([]);
            }
        });
        socket.addEventListener('ping', function () {});
        socket.addEventListener('message', function (ev) {
            try {
                var d = JSON.parse(ev.data);
                if (d && d.type === 'reload') triggerReload(d.files);
            } catch (e) {}
        });
        socket.addEventListener('error', function () {
            overlay('LiveReload error (SSE)', '#dc2626');
            try { socket.close(); } catch (e) {}
            scheduleReconnect();
        });
    }

    function connect() {
        ensurePort(function () {
            if (window.WebSocket) connectWebSocket();
            else connectSSE();
        });
    }

    function scheduleReconnect() {
        attempts++;
        var delay = Math.min(maxReconnectDelay, reconnectDelay * Math.min(attempts, 10));
        setTimeout(connect, delay);
    }

    function start() {
        if (resolvedOnce || wsPort !== null) {
            connect();
        } else {
            ensurePort(function () { connect(); });
        }
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(start, 0);
    } else {
        document.addEventListener('DOMContentLoaded', start);
    }
})();
