import { Button, CircularProgress, Grid } from "@mui/material";
import React, { useEffect, useState } from 'react';

export function ProductSide({addToCheck}) {
  const [products, setProducts]=useState([]);
  const [isLoading, setIsLoading]=useState(true);

  const getProducts= async()=>{
    setIsLoading(true);
    const response = await fetch('/products/counter', {
      method: 'get',
      headers: {
          'Content-Type': 'application/json;charset=utf-8',
          'X-CSRF-TOKEN': document.getElementById('meta_token').getAttribute('content')
      },
  });
  const products = await response.json();
  setProducts(products.products);
  setIsLoading(false);
  };

  useEffect(() => {
    getProducts();
  },[] );
  

  if (isLoading==true){
    return <div className="content-center">
      <CircularProgress></CircularProgress>
    </div>;
  }
  else{
    return <div className="grid grid-cols-3 gap-4 space-y-4 mx-4">
    {products.map((product)=><Button onClick={()=>addToCheck(product.name, 1, product.price, product.id)}><div className="flex flex-col justify-between" >
      <h3>{product.name}</h3>
      <div>{product.price},-</div>
    </div></Button>)}
    </div>
  }
}
