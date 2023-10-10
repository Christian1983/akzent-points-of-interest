<?php

namespace AkzentPointsOfInterest;

defined('ABSPATH') || exit;
class UpdateChecker
{
  public $plugin_slug;
  public $version;
  public $cache_key;
  public $cache_allowed;

  public function __construct()
  {
    $this->plugin_slug = AKZENT_POINTS_OF_INTEREST_PLUGIN_SLUG;
    $this->version = AKZENT_POINTS_OF_INTEREST_VERSION;
    $this->cache_key = 'akzent_points_of_interest_update_info_2';
    add_filter( 'plugins_api', array($this, 'info'), 20, 3 );
    add_filter( 'site_transient_update_plugins', array( $this, 'handle_plugin_update' ) );
  }

  public function handle_plugin_update( $update_plugins ) {
    if ( ! is_object( $update_plugins ) ) return $update_plugins;
    if ( ! isset( $update_plugins->response ) || ! is_array( $update_plugins->response ) ) $update_plugins->response = array();

    // prevent too many remote requests to akzent.de since wordpress fires 'site_transient_update_plugins' for every plugin installed.
    $update_info_cached = get_transient($this->cache_key);
    if ( $update_info_cached === false) {
      $update_info_new = $this->build_update_info();
      set_transient($this->cache_key, $update_info_new, DAY_IN_SECONDS);
      $update_plugins->response[$this->plugin_slug] = $update_info_new;
    } else {
      $update_plugins->response[$this->plugin_slug] = $update_info_cached;
    }

    return $update_plugins;
  }

  public function info($res, $action, $args) {
    if ('plugin_information' !== $action) return $res;
    if ($this->plugin_slug !== $args->slug) return $res;

    $update_info_cached = get_transient($this->cache_key);
    if ( $update_info_cached === false) {
      return $update_info_cached;
    } else {
      return $this->build_update_info();
    }
  }

  private function build_update_info() {
    $hash = $this->get_remote_info();
    $update_info = new \stdClass;
    $update_info->slug = $this->plugin_slug;
    $update_info->plugin =$hash->name;
    $update_info->new_version = $hash->version;
    $update_info->tested = $hash->tested;
    $update_info->package = $hash->download_url;
    $update_info->name = $hash->name;
    $update_info->requires = $hash->requires;
    $update_info->author = $hash->author;
    $update_info->author_profile = property_exists($hash, 'author_profile') ? $hash->author_profile : 'https://www.hotelkooperation.de/';
    $update_info->download_link = $hash->download_url;
    $update_info->trunk = $hash->download_url;
    $update_info->requires_php = $hash->requires_php;
    $update_info->last_updated = $hash->last_updated;

    $update_info->sections = array(
      'description' => $hash->sections->description,
      'installation' => $hash->sections->installation,
      'changelog' => property_exists($hash->sections, 'changelog') ? $hash->sections->changelog : ''
    );

    if (!empty($hash->banners)) {
      $update_info->banners = array(
        'low' => $hash->banners->low,
        'high' => $hash->banners->high
      );
    }

    return $update_info;
  }

  private function get_remote_info() {
    $response = wp_remote_get(
      'https://www.akzent.de/wp-plugin/info.json',
      array(
        'timeout' => 10,
        'headers' => array(
          'Accept' => 'application/json'
        )
      )
    );

    if (
      is_wp_error($response)
      || 200 !== wp_remote_retrieve_response_code($response)
      || empty(wp_remote_retrieve_body($response))
    ) {
      return false;
    }

    return json_decode(wp_remote_retrieve_body($response));
  }

}
