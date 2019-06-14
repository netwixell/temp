import React, {Component} from 'react';

import LeaderboardItem from '../leaderboard-item/leaderboard-item';

function setStatePromise(that, newState) {
  return new Promise((resolve) => {
      that.setState(newState, () => {
          resolve();
      });
  });
}

class Leaderboard extends Component {
  constructor(props){
    super(props);

    this.state = {
      error: false,
      isLoading: false,
      pollId: null,
      teams: []
    };
  }

  async componentDidMount(){
    await this.loadTeams();

    if(this.props.afterLoad){
      this.props.afterLoad();
    }

    window.Echo.channel('poll-'+this.state.pollId)
      .listen('.poll.new-vote', (e) => {
        this.incrementVotes(e.team_id);
      });

  }

  async loadTeams(){

    try {

      await setStatePromise(this, {isLoading:true});

      const response = await fetch(`${helpers.baseUrl}/teams?board`, {
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const json = await response.json();

      if(json.errors) throw json.errors;

      await setStatePromise(this, {
          isLoading: false,
          pollId: json.pollId,

          teams: [
            ...this.state.teams,
            ...json.teams
          ]
        });

    } catch (err){
      console.log(err);
      this.setState({
        error: err.message || err[0],
        isLoading: false,
       });
    }

  }

  incrementVotes(teamId){

    const index = this.state.teams.findIndex(team => team.id === teamId);

    if(index == -1) return;

    const team = Object.assign({}, this.state.teams[index]);

    team.votesCount++;

    const teams = Object.assign([], this.state.teams);

    teams[index] = team;

    this.setState({
      teams: teams.sort((a, b) => b.votesCount - a.votesCount )
    });

  }

  changePhoto(teamId){

    const index = this.state.teams.findIndex(team => team.id === teamId);

    if(index == -1) return;

    const team =  this.state.teams[index];

    if(!team.responsive || !team.responsive[0]) return;

    let image = document.getElementsByClassName('leaderboard__img')[0];

    let downloadingImage = new Image();
    downloadingImage.onload = function(){
      image.src = this.src;
      image.srcset = this.srcset;
    };

    downloadingImage.src = team.responsive[0].src;
    downloadingImage.srcset = team.responsive[0].srcset;

    // image.src = team.responsive[0].src;
    // image.srcset = team.responsive[0].srcset;

  }

  resetPhoto(){
    let image = document.getElementsByClassName('leaderboard__img')[0];
    image.src = '//:0';
    image.srcset = '';

  }

  render(){

    return (
      <>
      {this.state.teams.map((team)=>{
        return (
        <LeaderboardItem
          key={team.id}
          changePhoto={this.changePhoto.bind(this, team.id)}
          resetPhoto={this.resetPhoto.bind(this)}
          location={team.location}
          votesCount={team.votesCount}
          responsive={team.responsive}>
          {team.name}
          </LeaderboardItem>)
      })}
      </>
    );

  }
}

export default Leaderboard;
