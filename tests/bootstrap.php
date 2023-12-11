<?php

namespace {
    WP_Mock::activateStrictMode();
    WP_Mock::bootstrap();

    class WP_Widget{
        public function __construct()
        {
        }
    }
}
