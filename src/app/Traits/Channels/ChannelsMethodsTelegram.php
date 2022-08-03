<?php

namespace App\Traits\Channels;

trait ChannelsMethodsTelegram
{
  public function createGroup(string $title, string $description,  bool $megagroup = true): object
  {
    $this->telegram->channels->createChannel(megagroup: $megagroup, title: $title, about: $description);

    return $this;
  }

  public function getGroupsForDiscussion(): array
  {
    return $this->telegram->channels->getGroupsForDiscussion();
  }

  public function joinChannel($link)
  {
    $this->telegram->channels->joinChannel(channel: $link);

    return $this;
  }

  public function inviteToChannel($channel, $users)
  {
    $this->telegram->channels->inviteToChannel(channel: $channel, users: $users);

    return $this;
  }
}
