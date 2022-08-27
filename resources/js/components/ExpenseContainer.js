import React, { useEffect, useState, useRef } from 'react';
import ReactDOM from 'react-dom';
import Expense from './Expense';

function ExpenseContainer(props){
    const [expenses, setExpenses]=useState([]);
    const [isLoading, setIsLoading]=useState(true);
    
    useEffect(async()=>{
        setIsLoading(true);
        console.log(props);
        var body={};
        if(props.parameters.min){
            body.min=props.parameters.min;
        }
        if(props.parameters.max){
            body.max=props.parameters.max;
        }
        if(props.parameters.user!='all'){
            body.user= props.parameters.user;
        }
        if(props.parameters.search){
            body.search=props.parameters.search;
        }
        if (props.parameters.since){
            body.since=props.parameters.since;
        }
        if(props.parameters.until){
            body.until=props.parameters.until;
        }
        console.log(body);
        
        const response = await fetch('/admin/expenses/api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
                'X-CSRF-TOKEN': document.getElementById('meta_token').getAttribute('content')
            },

            body: JSON.stringify(body)
        });
        const expenses = await response.json();
        setExpenses(expenses.expenses);
        setIsLoading(false);
        console.log(expenses);

    }, [props]);

    
    
    if(isLoading==true){
        return <>
            <i className='fa fa-spinner fa-6x fa-spin '></i>
        </>;
    }
    return(
        <>
            {expenses.map((expense)=><Expense expense={expense}/>)}
        </>
    )
}

export default ExpenseContainer;