<?php

if (!file_exists( __DIR__.'/storage/installed')) {
    header('Location: public/install');
}else{
    header('Location: public');
}