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

  public function inviteToChannel(string $channel, array $users)
  {
    $this->telegram->channels->inviteToChannel(channel: $channel, users: $users);

    return $this;
  }

  // Need rebuild
  public function getChannels(array $channels)
  {
    return $this->telegram->channels->getChannels(id: $channels);
  }


  /**
   * @param channel - link for group.
   */
  public function getChannel($channel)
  {
    return $this->telegram->channels->getFullChannel(channel: $channel);
  }


  /**
   * @param group need link on the group. Not working with chanells(Issues error - 400). 
   * @param offset Start array. Patricals users for group.
   * @param limit limit length array. 
   */
  public function getParticipants(string|int $group, int $offset = 0, int $limit = 200, string $q = '', $hash = '')
  {
    return $this->telegram->channels->getParticipants(channel: $group, filter: ['_' => 'channelParticipantsSearch', 'q' => $q], offset: $offset, limit: $limit,);
  }
}
