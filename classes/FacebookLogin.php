<?php
use Elgg\DefaultPluginBootstrap;

class FacebookLogin extends DefaultPluginBootstrap {
  
  public function init() {
    // sign on with facebook
    if (facebook_login_allow_sign_on_with_facebook()) {
      elgg_extend_view('core/account/login_box', 'facebook_login/login_btn');
      elgg_extend_view('login/sidebar/login', 'facebook_login/login_btn');
    }
    
    elgg_register_event_handler('register', 'menu:page',	function(\Elgg\Event $event) {
      $user = elgg_get_page_owner_entity();
      if (!$user instanceof \ElggUser || !elgg_in_context('settings') || !$user->canEdit()) {
        return;
      }
      $return = $event->getValue();
      
      $return[] = \ElggMenuItem::factory([
        'name' => 'facebook_usersettings',
        'text' => elgg_echo('Facebook Login'),
        'href' => elgg_generate_url('usersettings:facebook_login', [
          'username' => $user->username,
        ]),
        'section' => 'configure',
      ]);
      
      return $return;
    });
  }
}