import { Card, CardContent } from "@mui/material";
import { forEach } from "lodash";
import React from "react";
import { useEffect, useState } from "react";
//import { Card, CardContent, CardActions, Typography, Button } from "@mui/material";

export function Checks({setName, setId, setCheck}) {
  const [checks, setChecks]=useState([]);
  const [isLoading, setIsLoading]=useState(true);

  const get= async()=>{
    const response = await fetch('/admin/checks');
    const parameters = await response.json();
    setChecks(parameters.checks);
    setIsLoading(false);
    console.log(checks);
  };

  useEffect(async ()=>{get();}, []);

  return <Card sx={{overflow: 'auto'}}>
    <CardContent >
      
      {isLoading ? <div><i className="fa fa-spinner fa-spin"/></div> :
      <div>
        {checks.map((check)=>
        <button className="bg-gray-50 border border-gray-200 rounded p-6 flex flex-col" onClick={()=>{
          setName(check.name);
          setId(check.id);
          setCheck(JSON.parse(check.cart));
          console.log('kkt');
        }}>
        <div>{check.name}</div>
        <div>{JSON.parse(check.cart).map((cartItem)=><div>{cartItem.item}, {cartItem.amount}</div>)}</div>
        </button>
        )}
      </div>
      }
    </CardContent>
    
  </Card>;
}
