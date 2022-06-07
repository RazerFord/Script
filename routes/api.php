<?php

$app->router->post('/save-lecture-file', "File@SaveLecture");
$app->router->post('/save-course-file', "File@SaveCourse");
$app->router->delete('/delete-file', "File@DeleteFile");
$app->router->get('/test', "File@test");
