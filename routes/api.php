<?php

$app->router->post('/save-lecture-file', "SaveFile@SaveLecture");
$app->router->post('/save-course-file', "SaveFile@SaveCourse");
