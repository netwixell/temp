import React, { Component, Fragment } from "react";

import {VoteTeamAtTime, VoteTeamAtEnd} from '../vote-team/vote-team';
import VoteGallery from '../vote-gallery/vote-gallery';
import Commercial from '../commercial/commercial';

function setStatePromise(that, newState) {
  return new Promise((resolve) => {
      that.setState(newState, () => {
          resolve();
      });
  });
}

class VoteTeamList extends Component {
  constructor(props){
    super(props);

     /**
     * VoteStates:
     * 0 - competition is over
     * 1 - poll is open
     * 2 - vote accepted
     * 3 - online poll is over
     */
    this.state = {
      error: false,
      isLoading: false,
      hasMore: true,
      pollId: null,
      voteState: 1,
      isVoted: false,

      isVotedCaption: null,
      giveVoteCaption: null,
      scoredCaption: null,
      votesCaption: null,

      pressedButton: null,
      commercials: [],
      skip: 0,
      take: 6,
      teams: []
    };

  }

  componentDidMount(){

    this.setState({
      take: helpers.isMobileDevice() ? 6 : 8
    }, async ()=>{
      await this.loadTeams();

      if(this.state.voteState == 2 && !this.state.isVoted) this.voted();

      window.Echo.channel('poll-'+this.state.pollId)
        .listen('.poll.new-vote', (e) => {
          this.incrementVotes(e.team_id);
        });

      window.addEventListener('scroll', this.handleOnScroll.bind(this));
    });

  }

  componentWillUnmount() {
    window.removeEventListener('scroll', this.handleOnScroll.bind(this));
  }

  voted(){
    let section = document.querySelector('.vote');

    this.setState({isVoted: true});
    section.classList.add('vote--isVoted');
  }


  handleOnScroll() {
    // http://stackoverflow.com/questions/9439725/javascript-how-to-detect-if-browser-window-is-scrolled-to-bottom
    var scrollTop = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
    var scrollHeight = (document.documentElement && document.documentElement.scrollHeight) || document.body.scrollHeight;
    var clientHeight = document.documentElement.clientHeight || window.innerHeight;
    var scrolledToBottom = Math.ceil( (scrollTop + clientHeight) * 1.15 ) >= scrollHeight - 300;

    if (scrolledToBottom) {

      if(this.state.isLoading || !this.state.hasMore) return;

      this.loadTeams();
    }
  }

  async loadTeams(){

    const {skip, take} = this.state;

    try {

      await setStatePromise(this, {isLoading:true});

      const response = await fetch(`${helpers.baseUrl}/teams?skip=${skip}&take=${take}`, {
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const json = await response.json();

      if(json.errors) throw json.errors;

      let commercials = [...this.state.commercials];

      if(json.commercial) commercials.push(json.commercial);

      let voteState = parseInt(json.voteState, 10);

      this.setState({
        commercials,
        voteState,
        isLoading: false,
        skip: (this.state.skip + this.state.take),
        hasMore: (this.state.take <= json.teams.length),
        pollId: json.pollId,

        isVotedCaption: json.isVotedCaption,
        giveVoteCaption: json.giveVoteCaption,
        scoredCaption: json.scoredCaption,
        votesCaption: json.votesCaption,
        commercialCaption: json.commercialCaption,

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

    this.setState({teams});

  }

  showTooltip(currId, e){

    const pressedButton = this.state.pressedButton;
    const teams = [...this.state.teams];
    const currIndex = this.state.teams.findIndex(team => team.id === currId);

    if(currIndex == -1) return;

    const currTeam = {...this.state.teams[currIndex]};

    currTeam.showTooltip = true;

    if(pressedButton){

      const prevIndex = this.state.teams.findIndex(team => team.id === pressedButton);

      if(prevIndex != -1 && prevIndex != currIndex){

        const prevTeam = {...this.state.teams[prevIndex]};
        prevTeam.showTooltip = false;
        teams[prevIndex] = prevTeam;

      }

    }

    teams[currIndex] = currTeam;

    setTimeout(()=>{
      this.hideTooltip();
    }, 2000);

    this.setState({
      teams,
      pressedButton: currId
    });

  }

  hideTooltip(){

    const currId = this.state.pressedButton;
    const teams = [...this.state.teams];
    const currIndex = this.state.teams.findIndex(team => team.id === currId);

    if(currIndex == -1) return;

    const currTeam = {...this.state.teams[currIndex]};

    currTeam.showTooltip = false;
    teams[currIndex] = currTeam;

    this.setState({
      teams,
      pressedButton: null
    });

  }

  async vote(id, e){

    if(this.state.isVoted) this.showTooltip(id, e);

    if(this.state.voteState != 1) return;

    e.target.blur();
    e.target.parentNode.blur();

    if(this.state.isLoading) return;

    try {
      await setStatePromise(this, {isLoading:true});

      const response = await fetch(helpers.baseUrl, {
        method: 'POST',
        body: JSON.stringify({team_id: id}), // data can be `string` or {object}!
        headers:{
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json'
        }
      });

      const json = await response.json();

      if(json.errors) throw json.errors;

      if(json.success){
        this.setState({isLoading: false, voteState:2});
        this.voted();
        setTimeout(()=>{
          this.setState({isVotedCaption: json.isVotedCaption});
        }, 2000);
      }

    } catch (err) {
      console.log(err);
    }
  }

  render(){

    var teamCard;

    if(this.state.voteState > 0 && this.state.voteState < 3){
      teamCard = (team) => {

        return (<VoteTeamAtTime
                  key={'team-'+team.id}
                  name={team.name}
                  location={team.location}
                  votesCount={team.votesCount}
                  responsive={team.responsive}
                  showTooltip={team.showTooltip}

                  tooltip={this.state.isVotedCaption}
                  giveVoteCaption={this.state.giveVoteCaption}
                  scoredCaption={this.state.scoredCaption}
                  votesCaption={this.state.votesCaption}

                  voteEvent={this.vote.bind(this, team.id)}>
                    <VoteGallery responsive={team.responsive} caption={team.caption}>{team.name}</VoteGallery>
                </VoteTeamAtTime>);
      };
    } else {
      teamCard = (team) => {
        return (<VoteTeamAtEnd
                  key={team.id}
                  name={team.name}
                  badge={team.badge}
                  resultsUrl={team.vote_results_url}
                  badgeCaption={team.badge_caption}
                  onlineVotesCaption={team.online_votes_caption}
                  judgeVotesCaption={team.judge_votes_caption}
                  location={team.location}
                  votesCount={team.votesCount}
                  >
                    <VoteGallery responsive={team.responsive} caption={team.caption}>{team.name}</VoteGallery>
                  </VoteTeamAtEnd>)
      };
    }

    var i,len,step,chunk = this.state.take,
      teams,
      commercial,
      commercialCount = this.state.commercials.length,
      elements = [];

    for (i=0,step=0,len=this.state.teams.length; i<len; i+=chunk, step++) {
        teams = this.state.teams.slice(i,i+chunk);

        elements.push(
          <ul className="vote__list" key={'teamGroup-'+step}>
            {teams.map(teamCard)}
          </ul>
        );
        if(step < commercialCount - 1){
          commercial = this.state.commercials[step];
          elements.push(
            <Commercial
              key={'commercial-'+step+'-'+commercial.id}
              title={commercial.title}
              link_url={commercial.link_url}
              link_title={commercial.link_title}
              srcset={commercial.srcset}
              src={commercial.src}
              caption={this.state.commercialCaption}
              >
              {commercial.caption}
            </Commercial>
          );
        }

    }

    return (<>{elements}</>);

  }
}

export default VoteTeamList;
