<?php

class Modal {
  private $modal;

  public function __construct(array $modal) {
    $default = [
      'id' => 'modal',
      'title' => 'Title',
      'content' => 'Content',
      'size' => 'modal-small',
      'autoLoad' => false,
    ];

    $this->modal = array_merge($default, $modal);
  }

  public function show() {
    $modal = '
  <div id="'.$this->modal["id"].'" class="modal '.$this->modal["size"].' '.($this->modal["autoLoad"] !== false ? 'default' : '').'">
    <div class="modal-content">
      <h4>'.$this->modal["title"].'</h4>
      <p>'.$this->modal["content"].'</p>
    </div>
  </div>';

    echo $modal;
  }
}