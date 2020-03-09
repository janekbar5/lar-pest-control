import axios from "axios";

const baseDomain = "http://www.lar-pest-control.test";
const baseURL = `${baseDomain}`; // Incase of /api/v1;

// ALL DEFUALT CONFIGURATION HERE

export default axios.create({
  baseURL,  
});