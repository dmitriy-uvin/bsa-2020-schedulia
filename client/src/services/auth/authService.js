import requestService from '@/services/requestService';

const authService = {
    async signIn(userLoginData) {
        const response = await requestService.post(
            '/auth/login',
            userLoginData
        );
        this.saveToken(response?.data?.data.access_token);
        return response?.data?.data;
    },
    async signUp(userRegisterData) {
        return await requestService.post('/auth/register', userRegisterData);
    },
    async signOut() {
        const response = await requestService.post('/auth/logout');
        this.removeToken();
        return response?.data?.data;
    },
    async fetchLoggedUser() {
        return await requestService.get('/users/me');
    },
    saveToken(token) {
        localStorage.setItem('auth.accessToken', token);
    },
    removeToken() {
        localStorage.setItem('auth.accessToken', '');
    },
    getToken() {
        return localStorage.getItem('auth.accessToken');
    },
    hasToken() {
        return !!localStorage.getItem('auth.accessToken');
    }
};

export default authService;