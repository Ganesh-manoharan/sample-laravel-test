<?php
namespace App\Http\Traits;

use App\Menu;
use App\UserRoles;
use Illuminate\Support\Facades\Auth;

trait MenuList{
	
	public static function menu($menu)
	{
		$user_role = UserRoles::where('user_id',Auth::user()->id)->first();
		return Menu::where('name',$menu)->join('menu_items','menu_items.menus_id','=','menus.id')->join('role_menus','role_menus.menu_items_id','=','menu_items.id')->select('menu_items.*','role_menus.*')->where('role_menus.role_id',$user_role->role_id)->orderBy('menu_items.order','ASC')->get();
		
	}
}
?>