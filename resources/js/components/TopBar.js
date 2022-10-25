import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import Button from '@mui/material/Button';

import IconButton from '@mui/material/IconButton';
import Typography from '@mui/material/Typography';
import Menu from '@mui/material/Menu';
import Container from '@mui/material/Container';

import MenuIcon from '@mui/icons-material/Menu';
import MenuItem from '@mui/material/MenuItem';


function TopBar(props){
    const [anchorElNav, setAnchorElNav] = React.useState(null);

    const handleOpenNavMenu = (event) => {
        setAnchorElNav(event.currentTarget);
      };

      const handleCloseNavMenu = () => {
        setAnchorElNav(null);
      };

    return (
        <AppBar position="static">
            <Container maxWidth="xl">
                <Toolbar disableGutters>
                <Typography
            variant="h6"
            noWrap
            component="a"
            href="/admin"
            sx={{
              mr: 2,
              
              fontFamily: 'monospace',
              fontWeight: 700,
              letterSpacing: '.3rem',
              color: 'inherit',
              textDecoration: 'none',
            }}
                >
                     Auris Pokladna
                </Typography>

                <Box sx={{ flexGrow: 1, display: { xs: 'none', md: 'flex' } }}>
                    <Button
                        onClick={()=>props.openDialog(props.setOpen)}
                        sx={{ my: 2, color: 'white', display: 'block' }}
                    >
                        Účty
                    </Button>
                    <Button 
                        sx={{ my: 2, color: 'white', display: 'block' }}
                        onClick={()=>{
                            props.setName();
                            props.setId();
                            props.setCheck([]);
                    }}>
                        Nový účet
                    </Button>            
                </Box>

                <Box sx={{ flexGrow: 1, display: { xs: 'flex', md: 'none' } }}>
                    <IconButton
                        size="large"
                        aria-label="account of current user"
                        aria-controls="menu-appbar"
                        aria-haspopup="true"
                        onClick={handleOpenNavMenu}
                        color="inherit"
                    >
                <MenuIcon />
                </IconButton>
                    <Menu
                        id="menu-appbar"
                        anchorEl={anchorElNav}
                        anchorOrigin={{
                            vertical: 'bottom',
                            horizontal: 'left',
                        }}
                        keepMounted
                        transformOrigin={{
                            vertical: 'top',
                            horizontal: 'left',
                        }}
                        open={Boolean(anchorElNav)}
                        onClose={handleCloseNavMenu}
                        sx={{
                            display: { xs: 'block', md: 'none' },
                         }}
                    >       
              
                <MenuItem onClick={()=>props.openDialog(props.setOpen)}>
                  <Typography textAlign="center">Účty</Typography>
                </MenuItem>
                <MenuItem onClick={()=>{props.setName();
                    props.setId();
                    props.setCheck([])}}>
                  <Typography textAlign="center">Nový účet</Typography>
                </MenuItem>
            </Menu>
          </Box>                
          

          
          
        

          
            </Toolbar></Container></AppBar>
    );
}

export default TopBar;