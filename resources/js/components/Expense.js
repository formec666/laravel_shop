import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import Status from './Status.js';
import Orders from './Orders.js';
import { LocalizationProvider } from '@mui/x-date-pickers-pro';
import { AdapterMoment } from '@mui/x-date-pickers/AdapterMoment';
import TextField from '@mui/material/TextField';
import moment from 'moment';
import InputAdornment from '@mui/material/InputAdornment';
import { MobileDateRangePicker } from '@mui/x-date-pickers-pro/MobileDateRangePicker';
import { Button } from '@mui/material';

function Expense(props){
    const [description, setDescription]=useState(props.expense.description);
    const [amount, setAmount]=useState(props.expense.amount);
    const [isSynced, setIsSynced]=useState(true);
    const [syncMessage, setSyncMessage]=useState();

    const changeDescription=(newValue)=>{
        setIsSynced(false);
        setDescription(newValue.target.value);
    };

    const changeAmount=(newValue)=>{
        setIsSynced(false);
        setAmount(newValue.target.value);
    };

    const sync = ()=>{
        var body={
            'amount': amount,
            'description':description
        };
         
        
        fetch("/admin/expenses/update/"+props.expense.id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
                'X-CSRF-TOKEN': document.getElementById('meta_token').getAttribute('content')
            },

            body: JSON.stringify(body)
        }).then(function(r)
        {
            if (r.status != 200) {
            setSyncMessage(r.status);
            return
            }
            else {
                setSyncMessage();
                setIsSynced(true);
            }
        }).catch(function(err) {alert('Error: '+err);});
    }

    return (<><div className='p-6 flex flex-row justify-between items-center'>
    
    <h1>{moment(props.expense.created_at).format('DD.MM.YYYY, hh:mm')}</h1>

    <TextField
          label="popis"
          value={description}
          margin='normal'
          type='text'
          id="outlined-end-adornment"
          onChange={changeDescription}
          onBlur={sync}
          
        />
    
    <TextField
          label="Hodnota"
          value={amount}
          margin='normal'
          type='number'
          id="outlined-end-adornment"
          onChange={changeAmount}
          onBlur={sync}
          
        />
    {props.expense.document ? 
    <a href={'/storage/'+props.expense.document}><i className="fa fa-file"></i></a>: <></>}


    <Button variant='contained' onClick={sync}>
    {isSynced ? <i className='fa fa-cloud-upload '></i> : <i className='fa fa-cloud-upload fa-spin'></i>}
    
    </Button>
    
    </div>
    <div className="text-sm text-slate-400">{syncMessage}</div></>);
}
export default Expense;