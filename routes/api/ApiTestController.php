<?php

ApiModel::controller('ApiTestController', function () {
    ApiModel::get('/info', 'info');
    ApiModel::get('/hello', 'helloWorld');
    ApiModel::get('/auth', 'withMiddleware', 'BearerAuthorizationMiddleware');
    ApiModel::get('/users/{id}', 'user');
    ApiModel::get('/posts/{postId}/comments/{commentId}', 'postComment');
});
