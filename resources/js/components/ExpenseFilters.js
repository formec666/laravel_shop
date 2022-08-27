import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import Status from './Status.js';
import Orders from './Orders.js';
import { LocalizationProvider } from '@mui/x-date-pickers-pro';
import { AdapterMoment } from '@mui/x-date-pickers/AdapterMoment';
import TextField from '@mui/material/TextField';
import InputAdornment from '@mui/material/InputAdornment';
import { MobileDateRangePicker } from '@mui/x-date-pickers-pro/MobileDateRangePicker';
import { Button } from '@mui/material';

const ExpenseFilters=({updateParams})=>{
    const [users, setUsers]=useState([]);
    const [isLoading, setIsLoading]=useState(true);
    const [value, setValue]=useState([null,null]);
    const [min, setMin]=useState();
    const [max, setMax]=useState();
    const [search, setSearch]=useState();
    const [user, setUser]=useState('all');

    const getParameters= async()=>{
        const response = await fetch('/admin/expenses/filters');
        const parameters = await response.json();
        setUsers(parameters.users);
        setMin(parameters.min);
        setMax(parameters.max);
        setSearch(null);
        setValue([null, null]);
        setIsLoading(false);
    }

    useEffect(()=>{
        getParameters();
    },[] );

    const handleRefresh= async()=>{
        setIsLoading(true);
        getParameters();
    };

    const handleSearch=()=>{
        updateParams(min, max, user, value, search);
    };

    if(isLoading==true){
    return(
        <div className='flex justify-center p-6 w-full'>
        <i className='fa fa-spinner fa-6x fa-spin '></i>
        </div>
    )}
    else{
    return(
        <form className='flex flex-col p-6 bg-yellow-100'>
            <label>
                Filtrovat zaměstnance
            </label>
            <select className='bg-transparent p-2 border border-solid border-stone-400 rounded' onChange={(e)=>{setUser(e.target.value)}}>
                <option value={'all'}>All</option>
                {users.map((user)=><>
                <option value={user.id}>{user.name}</option>
                </>)}
            </select>
            <label>Filtrovat dny</label>
            <LocalizationProvider
                dateAdapter={AdapterMoment}
                localeText={{ start: 'Od', end: 'Do' }}
            >
                <MobileDateRangePicker
                value={value}
                onChange={(newValue) => {
                setValue(newValue);
                }}
                    renderInput={(startProps, endProps) => (
                    <React.Fragment>
                    <TextField {...startProps} />
                    <TextField {...endProps} />
                    </React.Fragment>
                )}
                />
            </LocalizationProvider>
            <label>Filtrovat hodnotu</label>
            <TextField
          label="Minimální hodnota"
          value={min}
          type='number'
          margin='normal'
          id="outlined-end-adornment"
          onChange={(newValue)=>setMin(newValue.target.value)}
          InputProps={{
            endAdornment: <InputAdornment position="end">kč</InputAdornment>,
          }}
        />
        <TextField
          label="maximální hodnota"
          value={max}
          margin='normal'
          type='number'
          id="outlined-end-adornment"
          onChange={(newValue)=>setMax(newValue.target.value)}
          InputProps={{
            endAdornment: <InputAdornment position="end">kč</InputAdornment>,
          }}
        />
        <label>Hledat slovo</label>
        <TextField
          label="Hledaná slova"
          value={search}
          margin='normal'
          type='text'
          id="outlined-end-adornment"
          onChange={(newValue)=>setSearch(newValue.target.value)}
          InputProps={{
            
          }}
        />
        <Button
            onClick={()=>handleRefresh()}>
            <i className='fa fa-refresh fa-lg'></i>
        </Button>
        <Button
            variant='contained'
            onClick={handleSearch}>
            <i className='fa fa-search fa-3x'></i>
        </Button>
        
          
        </form>
    );}
}

export default ExpenseFilters;