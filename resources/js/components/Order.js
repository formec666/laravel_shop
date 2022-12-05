import { PropaneSharp } from '@mui/icons-material';
import { add, orderBy } from 'lodash';
import PreviousMap from 'postcss/lib/previous-map';
import React, { useEffect, useState } from 'react';

import ReactDOM from 'react-dom';

const statuses=[
    ['0','Nová', true, 'blue-500', 'Přijmout', 'blue-600', 'blue-700'],
    [ '1','Přijato', true, 'orange-500', 'Začít připravovat', 'orange-600', 'orange-700'],
    ['2' ,'Připravuje Se', true, 'amber-500', 'Připraveno',  'amber-600', 'amber-700'],
    ['3' ,'Připraveno', true, 'yellow-500', 'Odeslat',  'yellow-600', 'yellow-700'],
    ['4' ,'Na cestě', true, 'lime-500', 'Předat',  'lime-600', 'lime-700'],
    ['5' ,'Předáno', true, 'green-500', 'Archivovat',  'green-600', 'green-700'],
    ['6' ,'Stornováno', false, 'slate-500', 'Předáno',  'red-600', 'red-700'],    
    ['7' ,'Stornováno', false, 'slate-500', 'Předáno',  'slate-600', 'slate-700']];

function Order(props){
    const [cart, setCart]=useState(Object.values(JSON.parse(props.order.cart)));
    var buttonClass='bg-white border-2 p-2 font active:bg-slate-200 text-lg font-bold rounded-md border-'+statuses[props.order.status+1][3]+' text-'+statuses[props.order.status+1][3]+' hover:text-'+statuses[props.order.status+1][5];
    var className='flex flex-row justify-between landscape:w-1/5 p-6 font-bold uppercase text-2xl bg-'+statuses[props.order.status][3];

    const moveUp= async (passTo)=>{
        
        

        var to=props.order.status+passTo;
        
        if(passTo==6){
            to=7;
        }
        
        
        if(to==6){
            alert('Archivovat, nezle vrátit');
        }

        

        if(props.order.status==6){
            to=5;
        }
        
        var move=props.order.id;
        
        fetch('/admin/moveOrder', {
            method: 'post',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
            body: JSON.stringify({
                order: move,
                to: to
            })
        })
    };

    const getCart= async ()=>{
        const response= await fetch('/admin/cart', {
            method: 'post',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
            body: JSON.stringify({
                cart: props.order.cart
            })
        });
        const result= await response.json();
        console.log(result);

    }

    useEffect(()=>{
        console.log(cart[0]);
    }, [])
     

    return(
        <div className='flex flex-col portrait:flex-col landscape:flex-row flex-nowrap justify-between border-4 rounded-md border-slate-400 m-2'>
            <div className={className}>
                <div>{props.order.id} </div>
                <div>{statuses[props.order.status][1]}</div>
            </div>
            <div className='flex flex-row p-6 flex-wrap landscape:w-2/5 justify-between'>
                <div>
                    <div className='font-light'>Jméno a příjmení</div>
                    <div className='font-medium'>{props.order.name}</div>
                
                    <div className='font-light'>Adresa</div>
                    <div className='font-medium'>{props.order.address}</div>
                    
                    <div className='font-light'>Vytvořeno</div>
                    <div className='font-medium'>{props.order.created_at}</div>

                    <div className='font-light'>Platba</div>
                    <div className='font-medium' dangerouslySetInnerHTML={{ __html: props.order.payment_status }}></div>
                    
                </div>
                <div>{props.order.invoiceName && <><div className='font-light'>Jméno a příjmení na fakturu</div>
                    <div className='font-medium'>{props.order.invoiceName}</div></>}
                    
                    {props.order.invoiceAddress && <><div className='font-light'>Adresa na fakturu</div>
                    <div className='font-medium'>{props.order.invoiceAddress}</div></>}
                    
                    {props.order.note && <><div className='font-light'>Poznámka k obědnávce</div>
                    <div className='font-medium'>{props.order.note}</div></>}
                    
                    
                </div>
                <div>
                    <div className='flex flex-row landscape:w-2/5 justify-start p-6'>
                    <button className={buttonClass} onClick={()=>moveUp(+1)}><i className='fa fa-arrow-right mr-2'></i>{statuses[props.order.status][4]}</button>
                    <button onClick={()=>moveUp(-1)} className='bg-white border-2 p-2 font active:bg-slate-200 text-lg font-bold rounded-md border-slate-500 text-slate-500 hover:text-slate-700'><i className='fa fa-arrow-left mr-2'></i></button>
                    <button onClick={()=>moveUp(6)} className='bg-white border-2 p-2 font active:bg-slate-200 text-lg font-bold rounded-md border-slate-500 text-slate-500 hover:text-slate-700'><i className='fa fa-trash mr-2'></i></button>
                    </div>
                    <div className='font-light'>Změněno</div>
                    <div className='font-medium'>{props.order.updated_at}</div>
                    
                    
                </div>
                
            </div>
            <div>
            <div className='flex flex-col  p-6 flex-wrap justify-start bg-amber-100 border-3 border-slate-300'>
               
               {cart.map((item)=>
                <div className='flex flex-row  flex-wrap justify-between border-y-2'>
                    <div className='flex flex-row flex-wrap justify-start'>
                        <div className='font-bold text-red-500'>
                            {item.amount} × 
                        </div>
                        <div className='flex flex-row'>
                            {item.product.name} <div className='font-light'> ({item.product.id}, {item.product.price} Kč)</div>
                        </div>
                    </div>
                    <div className='font-bold'>
                        {item.product.price*item.amount} Kč
                    </div>

                </div>
               )}
                
            </div>

            <div className='border-t-2 border-slate-700 font-bold text-xl align-left bg-amber-200 flex-row flex justify-end'>
                Celkem: {props.order.total} Kč
            </div></div>
        </div>
    );

}
export default Order;