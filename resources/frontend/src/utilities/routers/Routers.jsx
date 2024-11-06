import React from 'react';
import {Route, Routes} from "react-router-dom";
import UserLogin from "../../components/login/UserLogin.jsx";

const Routers = () => {
    return (
        <Routes>
            <Route path='/' element={<UserLogin />} />
        </Routes>
    );
};

export default Routers;
