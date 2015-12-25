<?php
class SessionsModel extends Model
{
	public function clearUserById($id) {
		$this->delete("user_id={$id} AND id<>'".session_id()."'");
	}
}