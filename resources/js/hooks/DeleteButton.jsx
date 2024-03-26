import axios from 'axios';
import url from '../url';

const deleteData = async (endpoint, id) => {
    try {
        await axios.delete(`${url}${endpoint}/${id}`);
    } catch (error) {
        console.error('Error al eliminar datos:', error);
        throw error;
    }
};

export default deleteData;
