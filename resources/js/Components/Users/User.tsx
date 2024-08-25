import { User as UserType } from '@/types'

const User = ({ user }: { user: UserType}) => {
  return (
    <div className=' border-[1px] border-black p-3 m-1 rounded-md flex justify-between'>
        <div className=' flex flex-col '>
            {user.name + ' ID: ' + user.id}
            <img src={'/storage/' + user.photo} alt={user.name} className=' border w-[70px] h-auto'/>
        </div>

        <div className=' flex flex-col w-[30%] text-left gap-6'>
          <div>
            Email: {user.email}
          </div>
          <div>
            Phone: {user.phone}
          </div>
        </div>

        <div className='flex flex-col'>
            {user.position}
            <div>
              ID: {user.position_id}
            </div>
        </div>

        <div>
          With us since {user.email_verified_at?.slice(0, 10)}
        </div>
    </div>
  )
}

export default User