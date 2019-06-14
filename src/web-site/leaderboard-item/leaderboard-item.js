import React from 'react';

const LeaderboardItem = (props) => {

  return (
    <li className="team-list__item">
      <table className="team-list__team-table team-table">
        <tbody className="team-table__body" onMouseOver={!helpers.isMobileDevice() ? props.changePhoto : ()=>{}} onMouseOut={!helpers.isMobileDevice() ? props.resetPhoto : ()=>{}}>
          <tr className="team-table__title">
            <th>{props.children}</th>
          </tr>
          <tr className="team-table__address">
            <td>{props.location}</td>
          </tr>
          <tr className="team-table__votes">
            <td>{ (props.votesCount > 0) ? helpers.prettyNumber(props.votesCount) : '-'}</td>
          </tr>
        </tbody>
      </table>
    </li>
  );
}

export default LeaderboardItem;
