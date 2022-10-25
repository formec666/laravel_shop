import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import IconButton from '@mui/material/IconButton';
import Typography from '@mui/material/Typography';
import Menu from '@mui/material/Menu';
import Container from '@mui/material/Container';

import MenuIcon from '@mui/icons-material/Menu';
import Avatar from '@mui/material/Avatar';
import Button from '@mui/material/Button';
import Tooltip from '@mui/material/Tooltip';
import MenuItem from '@mui/material/MenuItem';
import TopBar from './TopBar';
import { Dialog } from '@mui/material';
import { CheckSide } from '../../views/components/CheckSide/CheckSide';
import { ProductSide } from '../../views/components/ProductSide/ProductSide';
import { Checks } from '../../views/components/Checks/Checks';

function Counter(){
    const [openCheck, setOpenCheck]=useState(false);
    const [name, setName]=useState();
    const [id, setId]=useState();
    const [check, setCheck]=useState([]);

    const acceptCheck = async() => {
      var  body={
        name: name,
        check: check,
        id: id,
        payment: "hotovost"
      };
      const response = await fetch('/admin/counter/checkout', {
        method: 'post',
        headers: {
              'Content-Type': 'application/json;charset=utf-8',
              'X-CSRF-TOKEN': document.getElementById('meta_token').getAttribute('content')
          },
          body: JSON.stringify(body)
      });
      var result = await response.json();
      setId();
      setName();
      setCheck([]);
      
    } 

    const syncCheck= async()=>{
      var body={
        name: name,
        check: check,
        id: id
      };
      
      
      const response = await fetch('/admin/counter', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'X-CSRF-TOKEN': document.getElementById('meta_token').getAttribute('content')
        },
        body: JSON.stringify(body)
      });
      const result = await response.json();
      setName(result.check.name);
      setName(name);
      setCheck(JSON.parse(result.check.cart));
      setCheck(check);
      setId(result.check.id);
    }

    
  


    const handleClose= (action)=>{
      action(false);
    }

    const handleOpen = (action)=>{
      action(true);
    }

    const addToCheck=(item, amount, price, id)=>{
      var newCheck = check;
      if(amount<=0){
        newCheck=newCheck.filter(function(jeden){ return jeden.item !== item });
        console.log(newCheck);
        setCheck([]);
        setCheck([...newCheck],()=>{
          console.log(check);
          syncCheck();
        });
        
        return null;
        
      }
      if(check.find(element=>element.item===item)==undefined){
        
        newCheck.push( {item:item, amount: amount, price: price, id: id});
                
        setCheck(newCheck);
        
      }
      else{ 
        
        newCheck[check.findIndex(element=>element.item===item)]={item: item, amount: amount, price: price, id: id};
        
        setCheck(newCheck);
      }
      setCheck([...check], ()=>{
        syncCheck();
      });
      
    };

    

    return (<>
      <TopBar openDialog={handleOpen} setOpen={setOpenCheck} setName={setName} setId={setId} setCheck={setCheck}/>
      <Dialog onClose={()=>handleClose(setOpenCheck)} open={openCheck}>
        <Checks setName={setName} setId={setId} setCheck={setCheck}/>
      </Dialog>
      <div className='flex flex-col landscape:flex-row justify-between relative flex-grow '>
        <div className=' bg-slate-100 w-full landscape:w-2/5  portrait:flex-grow p-2 overflow-y-auto'><CheckSide check={check} addToCheck={addToCheck} setCheck={setCheck} propName={name} setName={setName} syncCheck={syncCheck} acceptCheck={acceptCheck}/></div>
        <div className=' bg-white w-full landscape:w-3/5  portrait:flex-grow p-2 overflow-y-auto' ><ProductSide addToCheck={addToCheck} /></div>
      </div>
    
    </>)
}
    


export default Counter;

if (document.getElementById('counter')) {
    ReactDOM.render(<Counter />, document.getElementById('counter'));
}