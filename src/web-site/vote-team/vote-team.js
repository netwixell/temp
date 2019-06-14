import React from 'react';

const VoteTeamAtTime = (props) => {

  var buttonClass = 'card__button button button--unfilled-blue' + (props.showTooltip ? ' card__button--tooltip' : '');

  return (

    <li className="card card--vote">
      {props.children}
      <h3 className="card__name">{props.name}</h3>
      <p className="card__about">{props.location}</p>
      <div className="card__wrapper">
        <button className={buttonClass}
          data-tooltip={props.tooltip}
          onClick={props.voteEvent}
        >
        <span>{props.giveVoteCaption}</span>
        </button>
        { props.votesCount > 0
          ? <b className="card__score">{props.scoredCaption} {helpers.prettyNumber(props.votesCount)} {helpers.declOfNum(props.votesCount, props.votesCaption.split(','))}</b>
          : null
        }
      </div>
    </li>

  );
}

const VoteTeamAtEnd = (props) => {
  var badgeClass = (!props.badge || props.badge == 'FINALIST') ? 'card__badge' : 'card__badge card__badge--gold';

  return (
    <li className="card card--vote">
      {props.children}
      {props.badgeCaption ? <span className={badgeClass}>{props.badgeCaption}</span> : ''}
      <h3 className="card__name">{props.name}</h3>
      <p className="card__about">{props.location}</p>
      <div className="card__wrapper card__wrapper--end-vote">
        <b className="card__score">{props.onlineVotesCaption}</b>
        <a className="card__results" href={props.resultsUrl}>
          <span>{props.judgeVotesCaption}</span>
        </a>
      </div>
    </li>
  );

};

export {VoteTeamAtTime, VoteTeamAtEnd};
