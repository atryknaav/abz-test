import React from 'react'

const RegistrationForm = () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')!.getAttribute('content') || '';
    
  return (
    <div className='flex items-center flex-col shadow-lg p-10 rounded-2xl mb-6'>
        <form action="/users" method="post" encType="multipart/form-data" className="flex flex-col gap-6 w-[60%]">
        <input type="hidden" name="_token" value={csrfToken} />
    <label htmlFor="name">Full name</label>
    <input 
        type="text" 
        name="name" 
        placeholder="Name" 
        className="rounded-md focus:border-b-amber-300 focus:outline-0 outline-none border-t-0 border-x-0 border-b-2"
    />

    <label htmlFor="email">Email</label>
    <input 
        type="email" 
        name="email" 
        placeholder="example@email.com" 
        className="rounded-md focus:border-b-amber-300 focus:outline-0 outline-none border-t-0 border-x-0 border-b-2"
    />

    <label htmlFor="phone">Phone number</label>
    <input 
        type="tel" 
        name="phone" 
        placeholder="+380-123-456-789" 
        className="rounded-md focus:border-b-amber-300 focus:outline-0 outline-none border-t-0 border-x-0 border-b-2"
    />

    <label htmlFor="position_id">Position ID</label>
    <select 
        name="position_id" 
        className="rounded-lg border-t-0 border-x-0 border-b-2"
    >
        <option value="">Select a position</option>
        <option value={1}>1 - Lawyer</option>
        <option value={2}>2 - Content Manager</option>
        <option value={3}>3 - Security</option>
        <option value={4}>4 - Designer</option>
    </select>
    
    <label htmlFor="photo">Photo</label>
    <input 
        type="file" 
        name="photo" 
        accept="image/*" 
        className="rounded-md focus:border-b-amber-300 focus:outline-0 outline-none border-t-0 border-x-0 border-b-2"
    />

    <button 
        type="submit" 
        className="m-3 p-3 bg-cyan-600 text-white rounded-lg"
    >
        Register user
    </button>                
</form>
    <form action="/token" method='get'>
        <input type="hidden" name="_token" value={csrfToken} />
        <button type='submit' className=' bg-lime-400 m-3 p-3 text-gray-100 shadow-lg rounded-xl'>
            GET ACCESS
        </button>
    </form>
    </div>
  )
}

export default RegistrationForm