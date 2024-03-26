import axios from 'axios';
import url from '../url';

const useFetch = async (endpoint) => {
    try {
        const response = await axios.get(`${url}${endpoint}`);
        return response.data.data;
    } catch (error) {
        console.error(error);
        throw error;
    }
};

export default useFetch;
