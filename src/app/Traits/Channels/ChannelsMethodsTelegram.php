<?php

namespace App\Traits\Channels;

use danog\MadelineProto\channels;

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

  public function joinChannel(string $link): object
  {
    $this->telegram->channels->joinChannel(channel: $link);

    return $this;
  }

  public function leaveChannel(string $link): object
  {
    $this->telegram->channels->leaveChannel(channel: $link);

    return $this;
  }

  public function inviteToChannel(string $channel, array $users): object
  {
    $this->telegram->channels->inviteToChannel(channel: $channel, users: $users);

    return $this;
  }

  // Need rebuild
  public function getChannels(array $channels)
  {
    return $this->telegram->channels->getChannels(id: $channels);
  }

  public function getChannel($channel)
  {
    return $this->telegram->channels->getFullChannel(channel: $channel);
  }


  //$channel - need link 
  public function getParticipants(string|int $channel, int $offset = 0, int $limit = 40, string $q = '', $hash = '')
  {
    return $this->telegram->channels->getParticipants(channel: $channel, filter: ['_' => 'channelParticipantsSearch', 'q' => $q], offset: $offset, limit: $limit,);
  }
}
