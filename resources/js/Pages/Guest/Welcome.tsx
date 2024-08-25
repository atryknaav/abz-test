import { Link, Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import Guest from '@/Layouts/GuestLayout';

export default function Welcome({ auth, laravelVersion, phpVersion }: PageProps<{ laravelVersion: string, phpVersion: string }>) {
    const handleImageError = () => {
        document.getElementById('screenshot-container')?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document.getElementById('docs-card-content')?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };

    return (
        <Guest 
        
    >
        <Head title='Hi'/>
        
        <div>
            Hi
        </div>


        </Guest>
    );
}
