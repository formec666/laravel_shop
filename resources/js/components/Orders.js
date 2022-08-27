import { add, filter } from 'lodash';
import React, { useEffect, useState } from 'react';
import Order from './Order.js';

import ReactDOM from 'react-dom';



function Orders(props){
    const filters=props.data;
    //const[filters,setFilters]=useState(props.data);
    const[orders, setOrders]=useState([]);
    const[time, setTime]=useState(Date.now());

    useEffect(() => {
        const interval = setInterval(() => setTime(Date.now()), 1000);
        return () => {
          clearInterval(interval);
        };
      }, []);
    

    const filtersString= ()=>{
        var filtersString='';
        for(let k in filters){
            if(filters[k]==true){
                filtersString=filtersString+k;
            }
        }
        return filtersString;
    }
    
    

    const getOrders= async(filtersString)=>{
        const response = await fetch('/admin/allOrders?status='+filtersString);
        const movies = await response.json();

        setOrders(movies.orders);
        
    }
    

    useEffect(()=>{
        console.log(filters);
        getOrders(filtersString());
        
    },[filters]);

    useEffect(()=>{
        getOrders(filtersString());
        
    },[time]);
    //
    return (<div className='p-6'>
    
     {orders.map((order)=><Order order={order}/>)}
     
    </div>);
}
export default Orders;