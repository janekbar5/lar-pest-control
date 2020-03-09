import PostsRepository from './PostsRepository';
import UsersRepository from './UsersRepository';
import RecordsRepository from './RecordsRepository';

const repositories = {
    'posts': PostsRepository,
    'users': UsersRepository,
	'records': RecordsRepository,
	
}
export default {
    get: name => repositories[name]
};