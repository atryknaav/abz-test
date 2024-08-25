import { Head } from '@inertiajs/react';
import { PageProps, User } from '@/types';
import Guest from '@/Layouts/GuestLayout';
import Pagination from '@/Components/Pagination';

interface UsersProps {
    users: {
        data: User[];
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
    console.log(users)
    return (
        <Guest>
            <Head title="Users" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {users.data.map((user, index) => (
                                <div key={index}>
                                    {user.name}
                                </div>
                            ))}
                        </div>
                        <Pagination links={users.meta.links} />
                    </div>
                </div>
            </div>
        </Guest>
    );
}
