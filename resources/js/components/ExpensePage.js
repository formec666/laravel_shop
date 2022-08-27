import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import Status from './Status.js';
import Orders from './Orders.js';
import ExpenseFilters from './ExpenseFilters.js'
import ExpenseContainer from './ExpenseContainer.js';

function ExpensePage(){
    const [parameters, setParameters]=useState([]);
    const [expenses, setExpenses]=useState([]);
    
    const updateParams=(min, max, users, dates, search)=>{
        var data=[];
        data['min']=parseInt(min);
        data['max']=parseInt(max);
        data['user']=users;
        if(dates[0]!=null && dates[1]!=null){
        data['since']= dates[0].format('YYYY-MM-DD HH:mm:ss');
        data['until']= dates[1].format('YYYY-MM-DD HH:mm:ss');}
        data['search']=search;
        setParameters(data);
        setParameters((state)=>{
            return state;
        });
    };

    

    useEffect(async()=>{
        const response = await fetch('/admin/expenses/filters');
        const expens = await response.json();
        setExpenses(expens);
    }, [parameters]);

    return(
        <>
        <div className='flex flex-col md:flex-row-reverse justify-between flex-nowrap md:h-screen'>
            
            <div className=' bg-yellow-100 w-full md:w-1/5'>
                <ExpenseFilters updateParams={updateParams}/>
            </div>
            <div className=' bg-green-100 md:flex-nowrap md:overflow-y-auto md:hover:overflow-y-scroll w-full md:w-4/5 scrollbar:!w-1.5 scrollbar:!h-1.5 scrollbar:bg-transparent scrollbar-track:!bg-slate-100 scrollbar-thumb:!rounded scrollbar-thumb:!bg-slate-300 scrollbar-track:!rounded'>
                <ExpenseContainer parameters={parameters}/>
            </div>
        </div>
        </>
    );
}

if (document.getElementById('expenses')) {
    ReactDOM.render(<ExpensePage />, document.getElementById('expenses'));
}