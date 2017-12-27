<?php

// 应用公共文件

function D($name = '', $layer = 'model', $appendSuffix = false){
    return model($name, $layer, $appendSuffix);
}