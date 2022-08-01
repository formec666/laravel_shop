import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import Status from './Status.js';
import Orders from './Orders.js';


const statuses=[['0','Nová', true, 'blue-500', 'Přijmout', 'blue-600', 'blue-700'],
[ '1','Přijato', true, 'orange-500', 'Začít připravovat', 'orange-600', 'orange-700'],
['2' ,'Připravuje se', true, 'amber-500', 'Připraveno',  'amber-600', 'amber-700'],
['3' ,'Připraveno', true, 'yellow-500', 'Odeslat',  'yellow-600', 'yellow-700'],
['4' ,'Na cestě', true, 'lime-500', 'Předat',  'lime-600', 'lime-700'],
['5' ,'Předáno', false, 'green-500', 'Archivovat',  'green-600', 'green-700'],
['6' ,'Stornováno', false, 'slate-500', 'Archivovat',  'slate-600', 'slate-700']];
    


function Example() {
        const[status, setStatus]=useState(statuses);
        const [filters, setFilters]=useState();

        var data=[];

        const add = (id) => {
            setStatus(previousState => {
              return Object.values({ ...previousState, [id]: [previousState[id][0], previousState[id][1], true, previousState[id][3]]});
            });

            // status.forEach(element => {
            //     data[element[0]]=element[2];
            //     setFilters(data);
            // });
          }
          const remove = (id) => {

            setStatus(previousState => {
              return Object.values({ ...previousState, [id]: [previousState[id][0], previousState[id][1], false, previousState[id][3]]});
          });
        //    status.forEach(element => {
        //      data[element[0]]=element[2];
        //      setFilters(data);
        //  });
          }


        useEffect(()=>{
            status.forEach(element => {
            data[element[0]]=element[2];
            setFilters(data);
            
         });
        },[status]);

        
        return (   
        <div className="flex flex-col content-center">
                <div className="col-md-8 justify-content-center">
                    <div className="card">

                        <div className='flex flex-row flex-nowrap overflow-x-scroll items-center justify-between p-6'>
                            {status.map((status)=><Status 
                            name={status[1]} 
                            id={status[0]} 
                            bool={status[2]} 
                            colour={status[3]}
                            add={add}
                            remove={remove}
                            />)}
                        </div>
                        <Orders data={filters}/>

                    </div>
            </div>
        </div>
    );}


export default Example;

if (document.getElementById('orders')) {
    ReactDOM.render(<Example />, document.getElementById('orders'));
}
