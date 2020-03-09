import Repository from './Repository';
const resource = '/users';
const apiurl = '/v1/api/';

export default {
    index(model) {
        return Repository.get(`${apiurl}${model}/index`);
    },
	sortFilter(model,updateParams) {
        return Repository.get(`${apiurl}${model}/index?${updateParams}`);
    },	
    create(model) {
        return Repository.get(`${apiurl}${model}/create`)
    },	
    edit(model,id) {
        return Repository.get(`${apiurl}${model}/${id}/edit`)
    },
    createPost(model,payload) {
        return Repository.post(`${apiurl}${model}/create`, payload)
    },
    updatePost(model,id,payload) {
        return Repository.post(`${apiurl}${model}/update/${id}`, payload);
    },
    	
	delete(model,id) {
        return Repository.delete(`${apiurl}${model}/delete/${id}`)
    },

    // MANY OTHER ENDPOINT RELATED STUFFS
};