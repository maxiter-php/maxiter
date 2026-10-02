<?php
/*
Here is where you will configure all your API routes.
Use the HTTP verb helpers directly in a RESTful style.

@author Victor Béser
*/

ApiModel::get('/system/info', array('ApiTestController', 'info'));
ApiModel::get('/system/greeting', array('ApiTestController', 'helloWorld'));

ApiModel::get('/auth/me', array('ApiTestController', 'withMiddleware'), 'BearerAuthorizationMiddleware');

ApiModel::get('/users', array('ApiTestController', 'indexUsers'));
ApiModel::post('/users', array('ApiTestController', 'storeUser'));
ApiModel::get('/users/{id}', array('ApiTestController', 'showUser'));
ApiModel::put('/users/{id}', array('ApiTestController', 'updateUser'));
ApiModel::delete('/users/{id}', array('ApiTestController', 'destroyUser'));

ApiModel::get('/posts/{postId}/comments/{commentId}', array('ApiTestController', 'showPostComment'));
