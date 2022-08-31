<?php

namespace App\Models;

class InvitationsModel extends Model
{
  protected $table = "invitations_users";

  public function __construct()
  {
    parent::__construct($this->table);
  }
}
