import React from 'react';
import './style.css';

function DevCard({dev_info}){
  
  return(
    <div className="dev__card">
      <a href={`https://github.com/${dev_info.github_username}`} target="_blank">
        <div className="dev__card--overlay"></div>
        <div className="dev__card--avatar">
          <img 
            className="dev__card--avatar---image circle" 
            src={dev_info.avatar_url} 
            style={{margin: "auto"}}
          />
        </div>
        <div className="dev__card--name">{dev_info.name} - {dev_info.github_username}</div>
        <div className="dev__card--bio">
          {dev_info.bio}
        </div>
        <div className="dev__card--techs">
          {dev_info.techs}
        </div>
      </a>
    </div>
  )
}


export default DevCard;