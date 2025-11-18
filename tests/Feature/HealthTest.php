<?php

test('loads the homepage', function () {

    $response = $this->get('/');
    expect($response->status)->toBe(200);

});

test('h1 tag is present', function () {

    $response = $this->get('/');
    expect($response->body)->toContain('<h1>');

});