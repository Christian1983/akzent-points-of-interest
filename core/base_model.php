<?php

namespace AkzentPointsOfInterest\Core;

use function AkzentPointsOfInterest\Helper\to_snake_case;

defined('ABSPATH') || exit;

class BaseModel
{

  //beschreibt welche attribute die zb von einer api kommen
  //direkt im post oder wenn nicht in default_post_attributes vorhanden
  //dann in meta informationen gespeichert werden.
  const DEFAULT_POST_ATTRIBUTES = [
    'title' => 'post_title',
    'name' => 'post_title',
    'description' => 'post_content',
    'content' => 'post_content',
    'display' => 'post_status',
    'updated_at' => 'post_modified'
  ];

  private $attributes;

  private $attributes_ref;

  private $relations;

  private $new_record;


  public function __construct($attributes = null)
  {
    if ($attributes) {
      $this->new_record = true;
      $this->attributes = $attributes;
      $this->attributes_ref = $attributes;
    }
  }

  // getter für attributes
  // wir nutzten array_key_exists da wir auch ein return bei NULL wollen.
  public function __call($key, $args)
  {
    if (array_key_exists($key, $this->attributes)) {
      return $this->attributes[$key];
    } elseif (array_key_exists($key, $this->relations)) {
      //todo: implement relations
      //return $this->relations[$key];
      return null;
    } else {
      return null;
    }
  }

  public function save() {
    do_action(to_snake_case(get_called_class()) . '_after_save');
    return true;
  }

  public static function all()
  {
    $query_args = array(
      'post_type' => self::post_type_table_name(),
    );

    $post_query = new \WP_Query($query_args);
    return $post_query->posts;
  }

  public static function find($akzent_id)
  {
    $query_args = array(
      'post_type' => self::post_type_table_name(),
      'meta_query' => array(
        array(
          'key' => 'akzent_id',
          'value' => $akzent_id,
          'compare' => '='
        )
      )
    );

    $post_query = new \WP_Query($query_args);
    $a = $post_query->posts[0];
    $b = 1;
  }

  // holt alle post daten (post selbst und meta)
  // und baut den attributes array auf.
  private static function fetch_attributes_from_db($post_id)
  {
    $a = get_post($post_id);
    $b = get_post_meta($post_id);
    $c = 1;
  }

  private static function post_type_table_name()
  {
    $path = explode('\\', get_called_class());
    $a = to_snake_case(array_pop($path));
    return $a;
  }

}
