<?php
foreach (glob(__DIR__ . '/*/*.php') as $classFile) {
  require($classFile);
}
?>