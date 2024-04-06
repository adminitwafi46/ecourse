import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api";
const config = {
  headers: { "content-type": "multipart/form-data" },
};
function getToken() {
  return localStorage.getItem("token");
}

// Fungsi untuk membuat instance Axios dengan token otentikasi
const axiosInstance = axios.create({
  baseURL: API_URL,
  headers: {
    "Content-Type": "application/json",
    Authorization: `Bearer ${getToken()}`, // Menambahkan token ke header Authorization
  },
});

// Fungsi untuk memperbarui token di header setiap kali permintaan dibuat
axiosInstance.interceptors.request.use(
  (config) => {
    // Mendapatkan token terbaru dari localStorage dan memperbarui header Authorization
    config.headers.Authorization = `Bearer ${getToken()}`;
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

//register
export const register = async (userData) => {
  try {
    const response = await axios.post(`${API_URL}/auth/register`, userData);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//login
export const login = async (userData) => {
  try {
    const response = await axios.post(`${API_URL}/auth/login`, userData);

    if (response.data.user == "admin") {
      throw error;
    }
    const data = response.data;
    localStorage.setItem("token", data.access_token);
    localStorage.setItem("exp", data.expires_in);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//logout
export const logout = async () => {
  try {
    const response = await axiosInstance.post(`${API_URL}/auth/logout`);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//list courses
export const listCourses = async () => {
  try {
    //axios membawa token yang disimpan di localStorage sebagai auth bearer token
    const response = await axiosInstance.get("/course/index");
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//course detail
export const showCourse = async (courseId) => {
  try {
    const response = await axiosInstance.get(`/course/show/${courseId}`);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//user info
export const userInfo = async () => {
  try {
    const response = await axiosInstance.get("/auth/user");
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//store payment
export const storePayment = async (paymentData) => {
  try {
    const response = await axiosInstance.post("/payment/store", paymentData);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//tagihan
export const listTagihan = async () => {
  try {
    const response = await axiosInstance.get("/payment/tagihan");
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};
//invoice detail
export const showInvoice = async (invoice) => {
  try {
    const response = await axiosInstance.get(`/payment/invoice/${invoice}`);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//my_courses
export const myCourses = async () => {
  try {
    const response = await axiosInstance.get("/course/my_courses");
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//saveUser
export const saveUser = async (userData) => {
  try {
    const response = await axiosInstance.post("/auth/save_user", userData);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//save password
export const savePassword = async (passwordData) => {
  try {
    const response = await axiosInstance.post(
      "/auth/save_password",
      passwordData
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//learn now
export const learnNow = async () => {
  try {
    //const learnData diambil dari localStorage dengan nama selected_course
    const learnData = JSON.parse(localStorage.getItem("selected_course"));
    //console log url
    console.log(learnData);
    //get ke /course/learn_now dengan parameter id, id = learnData
    const response = await axiosInstance.get(`/course/learn_now/${learnData}`);

    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//dataCourse by id
export const dataCourse = async (courseId) => {
  try {
    const response = await axiosInstance.get(`/course/dataCourse/${courseId}`);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};
