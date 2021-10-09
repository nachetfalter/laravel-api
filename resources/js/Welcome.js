import axios from 'axios';
import React, { useState, useEffect } from 'react';
import useStateRef from 'react-usestateref';

function Welcome () {
    const [welcomeText, setWelcomeText] = useState('Welcome');

    useEffect(() => {
        axios.get('/get-text').then(response => {
            console.log(response);
            setWelcomeText(response.data);
        }).catch(err => {
            console.log(err);
        })
    });

    return (
        <div>
            <span>{welcomeText}</span>
        </div>
    )
}

export default Welcome
