<?php
class CacheFile
{

    private $_cache_path='';

    public function __construct($path)
    {
        $this->_cache_path = $path;
    }

	public function get($id)
	{
		if ( ! file_exists($this->_cache_path.$id)) {
			return FALSE;
		}

		$data = file_get_contents($this->_cache_path.$id);
		$data = unserialize($data);

		if (time() >  $data['time'] + $data['ttl']) {
			@unlink($this->_cache_path.$id);
			return FALSE;
		}

		return $data['data'];
	}

	public function set($id, $data, $ttl = 60)
	{
		$contents = array(
				'time'		=> time(),
				'ttl'		=> $ttl,
				'data'		=> $data
			);

		if (file_put_contents($this->_cache_path.$id, serialize($contents))) {
			@chmod($this->_cache_path.$id, 0777);
			return TRUE;
		}

		return FALSE;
	}

    public function delete($id)
    {
		if ( ! file_exists($this->_cache_path.$id)) {
			return FALSE;
		}   
        return @unlink($this->_cache_path.$id);
    }
}