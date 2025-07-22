<?php

test('loads the homepage', function () {
    
    $response = $this->get('/');
    $response->assertOk();

    $this->assertEquals(200, $response->status);

});