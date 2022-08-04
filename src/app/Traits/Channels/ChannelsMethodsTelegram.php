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
    print_r($this->telegram->channels->getGroupsForDiscussion());
    return $this;
  }

  public function joinChannel($link): object
  {
    $this->telegram->channels->joinChannel(channel: $link);

    return $this;
  }

  public function leaveChannel($link): object
  {
    $this->telegram->channels->leaveChannel(channel: $link);

    return $this;
  }

  public function inviteToChannel($channel, $users): object
  {
    $this->telegram->channels->inviteToChannel(channel: $channel, users: $users);

    return $this;
  }
}
