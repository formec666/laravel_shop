import { add } from 'lodash';
import React from 'react';

import ReactDOM from 'react-dom';

class Order extends React.Component {
    constructor(props){
        super(props);
    }
     
    
    render(props) {
      if(this.props.bool==true){
         var className="bg-"+this.props.colour+" border-lg border-"+this.props.colour+" text-white rounded py-2 px-4";
          return (
          <button className={className} onClick={()=>this.props.remove(this.props.id)}>{this.props.name}</button>
          );
        }
      var className="border-lg border-"+this.props.colour+" text-grey rounded py-2 px-4";
      return(
        
        <button className={className} onClick={()=>this.props.add(this.props.id)}>{this.props.name}</button>
      );
    }

    
  }
export default Order;