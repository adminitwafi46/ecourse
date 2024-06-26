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

// Mendapatkan daftar kursus
export const list_kursus = async () => {
  try {
    //axios membawa token yang disimpan di localStorage sebagai auth bearer token
    const response = await axiosInstance.get("/course/index");
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

// Membuat kursus baru
export const create_kursus = async (kursusData) => {
  try {
    const response = await axiosInstance.post(
      `${API_URL}/course/store`,
      kursusData
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

// Mendapatkan detail kursus berdasarkan ID
export const show_kursus = async (kursusId) => {
  try {
    const response = await axios.get(`${API_URL}/course/show/${kursusId}`);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

// memperbarui kursus berdasarkan ID
export const update_kursus = async (kursusId, kursusData) => {
  try {
    const response = await axiosInstance.put(
      `${API_URL}/course/update/${kursusId}`,
      kursusData
    );
    return response.data;
  } catch (error) {
    console.error(response);
    throw error;
  }
};

// Menghapus kursus berdasarkan ID
export const delete_kursus = async (kursusId) => {
  try {
    const response = await axios.delete(
      `${API_URL}/course/destroy/${kursusId}`
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//create bab baru
export const create_bab = async (babData) => {
  try {
    const response = await axiosInstance.post(`${API_URL}/bab/store`, babData);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//list bab dengan method post dengan parameter json
export const list_bab = async (kursusId) => {
  try {
    const response = await axiosInstance.post(`${API_URL}/bab/index`, {
      course_id: kursusId,
    });
    console.log(response);
    return response.data;
  } catch (error) {
    console.error("error");
    throw error;
  }
};

//show bab dengan parameter id
export const show_bab = async (babId) => {
  try {
    const response = await axiosInstance.get(`${API_URL}/bab/show/${babId}`);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//update bab dengan parameter id
export const update_bab = async (babId, babData) => {
  try {
    const response = await axiosInstance.put(
      `${API_URL}/bab/update/${babId}`,
      babData
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//delete bab dengan parameter id
export const delete_bab = async (babId) => {
  try {
    const response = await axiosInstance.delete(
      `${API_URL}/bab/destroy/${babId}`
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//materi store dengan config multipart form data
export const create_materi = async (materiData) => {
  try {
    const response = await axiosInstance.post(
      `${API_URL}/materi/store`,
      materiData,
      config
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//list materi dengan parameter bab_id, pake get
export const list_materi = async (babId) => {
  try {
    const response = await axiosInstance.get(
      `${API_URL}/materi/index/${babId}`
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//show materi dengan parameter id
export const show_materi = async (materiId) => {
  try {
    const response = await axiosInstance.get(
      `${API_URL}/materi/show/${materiId}`
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//update materi dengan parameter id (post)
export const update_materi = async (materiId, materiData) => {
  try {
    const response = await axiosInstance.post(
      `${API_URL}/materi/update/${materiId}`,
      materiData
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//delete materi dengan parameter id
export const delete_materi = async (materiId) => {
  try {
    const response = await axiosInstance.delete(
      `${API_URL}/materi/destroy/${materiId}`
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//membuat kuis baru
export const create_kuis = async (kuisData) => {
  try {
    const response = await axiosInstance.post(
      `${API_URL}/kuis/store`,
      kuisData
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//list kuis dengan parameter bab_id (get)
export const show_list_kuis = async (babId) => {
  try {
    const response = await axiosInstance.get(`${API_URL}/kuis/index/${babId}`);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//show kuis dengan parameter id
export const show_kuis_id = async (kuisId) => {
  try {
    const response = await axiosInstance.get(`${API_URL}/kuis/show/${kuisId}`);
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//update kuis dengan parameter id (post)
export const update_kuis_id = async (kuisId, kuisData) => {
  try {
    const response = await axiosInstance.post(
      `${API_URL}/kuis/update/${kuisId}`,
      kuisData
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//delete kuis dengan parameter id
export const delete_kuis_id = async (kuisId) => {
  try {
    const response = await axiosInstance.delete(
      `${API_URL}/kuis/destroy/${kuisId}`
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//show list jawaab kuis dengan parameter kuis_id
export const show_list_jawaban_kuis = async (kuisId) => {
  try {
    const response = await axiosInstance.get(
      `${API_URL}/jawaban/index/${kuisId}`
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//jawaban baru (post)
export const create_jawaban = async (jawabanData) => {
  try {
    const response = await axiosInstance.post(
      `${API_URL}/jawaban/store`,
      jawabanData
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//update jawaban benar dengan parameter id (get)
export const update_jawaban_benar = async (jawabanId) => {
  try {
    const response = await axiosInstance.get(
      `${API_URL}/jawaban/benar/${jawabanId}`
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};

//delete jawaban dengan parameter id
export const delete_jawaban = async (jawabanId) => {
  try {
    const response = await axiosInstance.delete(
      `${API_URL}/jawaban/destroy/${jawabanId}`
    );
    return response.data;
  } catch (error) {
    console.error(error);
    throw error;
  }
};
