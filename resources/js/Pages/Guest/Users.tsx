import React from 'react';
import { Head } from '@inertiajs/react';
import { UsersResponse, usersResponse422 } from '@/types';
import Guest from '@/Layouts/GuestLayout';
import Pagination from '@/Components/Pagination';
import User from '@/Components/Users/User';
import NavLink from '@/Components/NavLink';

interface UsersProps {
    usersResponse: UsersResponse;
    usersResponse422?: usersResponse422;
}

export default function Users({ usersResponse, usersResponse422 }: UsersProps) {
    const { users, page, count, total_pages, total_users, success } = usersResponse;
    const error = usersResponse422;

    return (
        <Guest>
            <Head title="Users" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {success ? (
                                <>
                                    <p className="text-gray-500">Current Page: {page}</p>
                                    <p className="text-gray-500">Total Users: {total_users}</p>
                                    <p className="text-gray-500">Total Pages: {total_pages}</p>
                                    {users.data.map((user, index) => (
                                        <div key={index}>
                                            <User user={user} />
                                        </div>
                                    ))}
                                </>
                            ) : (
                                error && (
                                    <div className="text-red-500">
                                        <p>{error.message}</p>
                                        <ul>
                                            {Object.entries(error.fails).map(([key, message]) => (
                                                <li key={key}>{message}</li>
                                            ))}
                                        </ul>
                                    </div>
                                )
                            )}
                        </div>
                        <form action={`/users?page=${page}&perPage=${count}`} method="get">
                            <label htmlFor="perPage">Users per page</label>
                            <input
                                id="perPage"
                                name="perPage"
                                type="number"
                                className="m-2 p-2 rounded-md"
                                defaultValue={count}
                            />
                            <input type="text" className='hidden' name='page' value={page}/>
                            <button type="submit">Apply</button>
                        </form>
                        {success ? (<Pagination perPage={count} links={users.meta.links} />) : (<NavLink href='/users?page=1&perPage=5' active={route().current('dashboard')}>
                            Go to the first page
                        </NavLink>)}
                    </div>
                </div>
            </div>
        </Guest>
    );
}
