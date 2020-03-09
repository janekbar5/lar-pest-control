import Repository from './Repository';
const resource = '/posts';

export default {
    get() {
        return Repository.get(`${resource}`);
    },
    getPost(id) {
        return Repository.get(`${resource}/${id}`);
    },
    create(payload) {
        return Repository.post(`${resource}`, payload);
    },
    update(payload, id) {
        return Repository.put(`${resource}/${id}`, payload);
    },
    delete(id) {
        return Repository.delete(`${resource}/${id}`)
    },

    // MANY OTHER ENDPOINT RELATED STUFFS
};