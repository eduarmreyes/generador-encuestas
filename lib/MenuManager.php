<?php

/**
 * Menu Manager.
 *
 * @package    menumanager
 * @author     Karla Rivas
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MenuManager {

    private $menu = array();
    private $initialized = false;

    public function __construct() {
        
    }

    public function getMainMenu($application, $userCredentials) {
        $raw = array();
        $mainMenu = array();
        $pointer = 0;

        if (!$this->initialized) {
            $this->initMenu($application, $userCredentials);
        }

        $raw = $this->getMenu();

        foreach ($raw as $r) {
            if ($r['level'] == '1') {
                $mainMenu[$pointer] = $r;
                $pointer++;
            }
        }

        return $mainMenu;
        //return $this->menu;
    }

    public function getSecondaryMenu($application, $parent) {
        $raw = array();
        $secondaryMenu = array();
        $pointer = 0;

        if (!$this->initialized) {
            $this->initMenu($application);
        }

        $raw = $this->getMenu();

        foreach ($raw as $r) {
            if ($r['level'] == '2' && $r['group'] == $parent) {
                $secondaryMenu[$pointer] = $r;
                $pointer++;
            }
        }

        return $secondaryMenu;
    }

    public function getMenu() {
        return $this->menu;
    }

    private function initMenu($application, $userCredentials) {
        //variables
        $values = array();
        $menu_array = array();
        $pointer = 0;
        $start = false;

        //Init array
        $values['group'] = '';
        $values['module'] = '';
        $values['action'] = '';
        $values['link_title'] = '';
        $values['link_path'] = '';
        $values['hidden'] = '';
        $values['hasChild'] = false;
        $values['level'] = '';
        $values['label'] = '';
        $values['credential'] = '';
        $values['options'] = array();

        $file = dirname(__FILE__) . '/' . $application . '.yml';

        $aRawMenu = sfYaml::load($file);

        foreach ($aRawMenu as $m) {
            /* First clean values */
            $values['group'] = '';
            $values['module'] = '';
            $values['action'] = '';
            $values['link_title'] = '';
            $values['link_path'] = '';
            $values['hidden'] = '';
            $values['hidden'] = false;
            $values['level'] = '';
            $values['label'] = '';
            $values['credential'] = '';
            $values['options'] = array();
            
            $menuCredentials =  $m['credential'];
            if (count(array_intersect($userCredentials, $menuCredentials)) > 0) {
                /* Now get the values for this row */
                $values['group'] = $m['group'];
                $values['module'] = $m['module'];
                $values['action'] = $m['action'];
                $values['link_title'] = $m['link_title'];
                $values['hidden'] = $m['hidden'];
                $values['hasChild'] = $m['hasChild'];
                $values['level'] = $m['level'];
                $values['label'] = $m['label'];

                if (isset($m['options'])) {
                    if (count($m['options'] > 0)) {
                        foreach ($m['options'] as $opt) {
                            $values['options'][] = array(
                                'group' => $opt["group"],
                                'module' => $opt['module'],
                                'action' => $opt['action'],
                                'link_title' => $opt['link_title'],
                                'label' => (isset($opt['i18n_label'])) ? $opt["i18n_label"] : $opt["link_title"]
                            );
                        }
                    }
                }

                $menu_array[] = $values;
            }
        }

        $this->initialized = true;
        $this->menu = $menu_array;
    }

}
?>

