import { Head } from '@inertiajs/react';
import { PageProps, User as UserType } from '@/types';
import Guest from '@/Layouts/GuestLayout';
import Pagination from '@/Components/Pagination';
import User from '@/Components/Users/User';
import { useState, useEffect } from 'react';

interface UsersProps {
    users: {
        data: UserType[];
        meta: {
            links: {
                url: string | null;
                label: string;
                active: boolean;
            }[];
        };
    };
}

export default function Users({ users }: UsersProps) {
    const [perPage, setPerPage] = useState<number>(5);

    useEffect(() => {
        const urlParams = new URLSearchParams(window.location.search);
        const perPageParam = urlParams.get('perPage');
        if (perPageParam) {
            setPerPage(Number(perPageParam));
        }
    }, []);

    return (
        <Guest>
            <Head title="Users" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {users.data.map((user, index) => (
                                <div key={index}>
                                    <User user={user} />
                                </div>
                            ))}
                        </div>
                        <form action="" method="GET">
                            <label htmlFor="perPage">Users per page</label>
                            <input
                                id="perPage"
                                name="perPage"
                                type="number"
                                className='m-2 p-2 rounded-md'
                                value={perPage}
                                onChange={(e) => setPerPage(Number(e.target.value))}
                            />
                            <button type="submit" className='bg-blue-500 text-white p-2 rounded-md'>Apply</button>
                        </form>
                        <Pagination links={users.meta.links} />
                    </div>
                </div>
            </div>
        </Guest>
    );
}
