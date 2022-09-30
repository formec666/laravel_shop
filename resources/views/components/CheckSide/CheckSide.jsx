import { Card, CardContent, CardActions, Typography, Button } from "@mui/material";
import React, { useEffect, useState } from "react";
import AddIcon from '@mui/icons-material/Add';
import IconButton from '@mui/material/IconButton';
import RemoveIcon from '@mui/icons-material/Remove';
import DeleteIcon from '@mui/icons-material/Delete';
import TextField from '@mui/material/TextField';
import { setSectionValue } from "@mui/x-date-pickers/internals/hooks/useField/useField.utils";
import { BorderHorizontal } from "@mui/icons-material";

export function CheckSide({check, addToCheck, propName, setName, syncCheck}) {
  


  return <>
    <Card sx={{marginBottom: 2}}>
      <CardContent>
      <TextField id="standard-basic" label="Jméno" variant="standard" value={propName} onChange={(newValue)=>setName(newValue.target.value)} onBlur={syncCheck}/>
      </CardContent>
    </Card>
    {check.map((element)=><Card sx={{marginBottom: 2}}><CardContent><div className="flex flex-row justify-between">
    <div className="w-1/3">
        {element.item}

      <Typography  color="text.secondary" gutterBottom>
        {element.price} Kč
      </Typography>
      
      
    </div>
    <div>
      <IconButton size="small" onClick={()=> addToCheck(element.item, element.amount-1, element.price, element.id)} onBlur={syncCheck}><RemoveIcon fontSize="small"></RemoveIcon></IconButton>
      {element.amount}
      <IconButton size="small" onClick={()=>addToCheck(element.item, element.amount+1, element.price, element.id)} onBlur={syncCheck}><AddIcon fontSize="small"></AddIcon></IconButton>
    </div>

    <div className="flex flex-col">
        {element.amount*element.price} Kč
        <IconButton size="small" onClick={()=> addToCheck(element.item, 0, element.price, element.id)} onBlur={syncCheck}><DeleteIcon fontSize='small'></DeleteIcon></IconButton>
          
      
      
      
    </div></div></CardContent>
    </Card>)}
  </>;
}
