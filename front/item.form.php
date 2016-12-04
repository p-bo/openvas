<?php
/*
/*
 * @version $Id$
 LICENSE

  This file is part of the openvas plugin.

 OpenVAS plugin is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 3 of the License, or
 (at your option) any later version.

 openvas plugin is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; along with openvas. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 @package   openvas
 @author    Teclib'
 @copyright Copyright (c) 2016 Teclib'
 @license   GPLv3
            http://www.gnu.org/licenses/gpl.txt
 @link      https://github.com/pluginsGLPI/openvas
 @link      http://www.glpi-project.org/
 @link      http://www.teclib-edition.com/
 @since     2016
 ---------------------------------------------------------------------- */
 ---------------------------------------------------------------------- */

include ("../../../inc/includes.php");

Session::checkRight('plugin_openvas_item', READ);

$item = new PluginOpenvasItem();
if (isset($_REQUEST['_in_modal']) && $_REQUEST['_in_modal']) {
  Html::nullHeader();
  PluginOpenvasItem::showFormAddTask();
  Html::nullFooter();
} else {
  if (isset($_POST['update'])) {
     $item->update($_POST);
     PluginOpenvasItem::updateItemFromOpenvas($_POST['id']);
  }
  if (isset($_REQUEST['refresh'])) {
     PluginOpenvasItem::updateItemFromOpenvas($_REQUEST['id']);
  } elseif (isset($_GET['action'])
     && isset($_GET['task_id'])
        && !empty($_GET['task_id'])) {

    switch ($_GET['action']) {
      case PluginOpenvasOmp::START_TASK:
        PluginOpenvasOmp::startTask($_GET['task_id']);
        break;
      case PluginOpenvasOmp::CANCEL_TASK:
        PluginOpenvasOmp::stopTask($_GET['task_id']);
        break;
      default:
        break;
    }
  }
  if (isset($_POST['add'])) {
     if (isset($_REQUEST['id'])) {
        unset($_REQUEST['id']);
     }
     $item->add($_REQUEST);
  }
  Html::back();

}
