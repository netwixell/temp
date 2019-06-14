import React from 'react';
import ReactDOM from 'react-dom';

import ButtonLeaderboard from './vote/button-leaderbord-toggle';

import VoteTeamList from './vote-team-list/vote-team-list';
import Leaderboard from './leaderboard/leaderboard';
import './button-to-top/button-to-top';

import Echo from 'laravel-echo';

window.io = require('socket.io-client');

const host = document.querySelector('meta[name="laravel-echo-server-url"]').getAttribute('content');

window.Echo = new Echo({
  broadcaster: 'socket.io',
  host
});

ReactDOM.render(<VoteTeamList />, document.getElementById('vote-team-list'));

ButtonLeaderboard((callback) => {

  ReactDOM.render(<Leaderboard afterLoad={callback} />, document.getElementById('leaderboard-list'));

});
