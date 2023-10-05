<?php

class NuxPackage {

    private $items = [];
    private string $name = "";
    private string $description = "";
    private string $author = "";
    private string $version = "";

    public function __construct() {
        $data = $this->read_nux();
        $this->name = $data['name'] ?? 'Nexus 3 Package';
        $this->description = $data['description'] ?? '';
        $this->author = $data['author'] ?? 'Unknown';
        $this->version = $data['version'] ?? '';
    }

    /**
     * @return array|null returns array of data if nuxspec present, otherwise null
     */
    private function read_nux(): array|null {
        $cwd = getcwd();

        if (file_exists($cwd . 'nuxspec')) {
            $data = file_get_contents($cwd . 'nuxspec');
            $data = json_decode($data, true);
            return $data;
        } else {
            return null;
        }
    }

    /**
     * Serialize package into a .nxs file for loading into Nexus
     * @return int returns 0 on success
     */
    public function save_nxs(): int {
        return 1;
    }
}