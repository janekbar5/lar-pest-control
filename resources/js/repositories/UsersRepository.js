import Repository from './Repository';
const resource = '/users';

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
	
	delete2(model,id) {
        return Repository.delete(`/v1/api/${model}/${id}`)
    },

    // MANY OTHER ENDPOINT RELATED STUFFS
};