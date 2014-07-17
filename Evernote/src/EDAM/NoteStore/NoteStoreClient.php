<?php


namespace EDAM\NoteStore;


class NoteStoreClient implements \EDAM\NoteStore\NoteStoreIf {
    protected $input_ = null;
    protected $output_ = null;

    protected $seqid_ = 0;

    public function __construct($input, $output=null) {
        $this->input_ = $input;
        $this->output_ = $output ? $output : $input;
    }

    public function getSyncState($authenticationToken)
    {
        $this->send_getSyncState($authenticationToken);
        return $this->recv_getSyncState();
    }

    public function send_getSyncState($authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_getSyncState_args();
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getSyncState', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getSyncState', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getSyncState()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getSyncState_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getSyncState_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("getSyncState failed: unknown result");
    }

    public function getSyncStateWithMetrics($authenticationToken, \EDAM\NoteStore\ClientUsageMetrics $clientMetrics)
    {
        $this->send_getSyncStateWithMetrics($authenticationToken, $clientMetrics);
        return $this->recv_getSyncStateWithMetrics();
    }

    public function send_getSyncStateWithMetrics($authenticationToken, \EDAM\NoteStore\ClientUsageMetrics $clientMetrics)
    {
        $args = new \EDAM\NoteStore\NoteStore_getSyncStateWithMetrics_args();
        $args->authenticationToken = $authenticationToken;
        $args->clientMetrics = $clientMetrics;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getSyncStateWithMetrics', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getSyncStateWithMetrics', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getSyncStateWithMetrics()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getSyncStateWithMetrics_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getSyncStateWithMetrics_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("getSyncStateWithMetrics failed: unknown result");
    }

    public function getSyncChunk($authenticationToken, $afterUSN, $maxEntries, $fullSyncOnly)
    {
        $this->send_getSyncChunk($authenticationToken, $afterUSN, $maxEntries, $fullSyncOnly);
        return $this->recv_getSyncChunk();
    }

    public function send_getSyncChunk($authenticationToken, $afterUSN, $maxEntries, $fullSyncOnly)
    {
        $args = new \EDAM\NoteStore\NoteStore_getSyncChunk_args();
        $args->authenticationToken = $authenticationToken;
        $args->afterUSN = $afterUSN;
        $args->maxEntries = $maxEntries;
        $args->fullSyncOnly = $fullSyncOnly;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getSyncChunk', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getSyncChunk', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getSyncChunk()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getSyncChunk_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getSyncChunk_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("getSyncChunk failed: unknown result");
    }

    public function getFilteredSyncChunk($authenticationToken, $afterUSN, $maxEntries, \EDAM\NoteStore\SyncChunkFilter $filter)
    {
        $this->send_getFilteredSyncChunk($authenticationToken, $afterUSN, $maxEntries, $filter);
        return $this->recv_getFilteredSyncChunk();
    }

    public function send_getFilteredSyncChunk($authenticationToken, $afterUSN, $maxEntries, \EDAM\NoteStore\SyncChunkFilter $filter)
    {
        $args = new \EDAM\NoteStore\NoteStore_getFilteredSyncChunk_args();
        $args->authenticationToken = $authenticationToken;
        $args->afterUSN = $afterUSN;
        $args->maxEntries = $maxEntries;
        $args->filter = $filter;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getFilteredSyncChunk', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getFilteredSyncChunk', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getFilteredSyncChunk()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getFilteredSyncChunk_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getFilteredSyncChunk_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("getFilteredSyncChunk failed: unknown result");
    }

    public function getLinkedNotebookSyncState($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook)
    {
        $this->send_getLinkedNotebookSyncState($authenticationToken, $linkedNotebook);
        return $this->recv_getLinkedNotebookSyncState();
    }

    public function send_getLinkedNotebookSyncState($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook)
    {
        $args = new \EDAM\NoteStore\NoteStore_getLinkedNotebookSyncState_args();
        $args->authenticationToken = $authenticationToken;
        $args->linkedNotebook = $linkedNotebook;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getLinkedNotebookSyncState', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getLinkedNotebookSyncState', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getLinkedNotebookSyncState()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getLinkedNotebookSyncState_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getLinkedNotebookSyncState_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getLinkedNotebookSyncState failed: unknown result");
    }

    public function getLinkedNotebookSyncChunk($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook, $afterUSN, $maxEntries, $fullSyncOnly)
    {
        $this->send_getLinkedNotebookSyncChunk($authenticationToken, $linkedNotebook, $afterUSN, $maxEntries, $fullSyncOnly);
        return $this->recv_getLinkedNotebookSyncChunk();
    }

    public function send_getLinkedNotebookSyncChunk($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook, $afterUSN, $maxEntries, $fullSyncOnly)
    {
        $args = new \EDAM\NoteStore\NoteStore_getLinkedNotebookSyncChunk_args();
        $args->authenticationToken = $authenticationToken;
        $args->linkedNotebook = $linkedNotebook;
        $args->afterUSN = $afterUSN;
        $args->maxEntries = $maxEntries;
        $args->fullSyncOnly = $fullSyncOnly;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getLinkedNotebookSyncChunk', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getLinkedNotebookSyncChunk', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getLinkedNotebookSyncChunk()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getLinkedNotebookSyncChunk_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getLinkedNotebookSyncChunk_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getLinkedNotebookSyncChunk failed: unknown result");
    }

    public function listNotebooks($authenticationToken)
    {
        $this->send_listNotebooks($authenticationToken);
        return $this->recv_listNotebooks();
    }

    public function send_listNotebooks($authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_listNotebooks_args();
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'listNotebooks', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('listNotebooks', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_listNotebooks()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_listNotebooks_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_listNotebooks_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("listNotebooks failed: unknown result");
    }

    public function getNotebook($authenticationToken, $guid)
    {
        $this->send_getNotebook($authenticationToken, $guid);
        return $this->recv_getNotebook();
    }

    public function send_getNotebook($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getNotebook failed: unknown result");
    }

    public function getDefaultNotebook($authenticationToken)
    {
        $this->send_getDefaultNotebook($authenticationToken);
        return $this->recv_getDefaultNotebook();
    }

    public function send_getDefaultNotebook($authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_getDefaultNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getDefaultNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getDefaultNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getDefaultNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getDefaultNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getDefaultNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("getDefaultNotebook failed: unknown result");
    }

    public function createNotebook($authenticationToken, \EDAM\Types\Notebook $notebook)
    {
        $this->send_createNotebook($authenticationToken, $notebook);
        return $this->recv_createNotebook();
    }

    public function send_createNotebook($authenticationToken, \EDAM\Types\Notebook $notebook)
    {
        $args = new \EDAM\NoteStore\NoteStore_createNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $args->notebook = $notebook;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'createNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('createNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_createNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_createNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_createNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("createNotebook failed: unknown result");
    }

    public function updateNotebook($authenticationToken, \EDAM\Types\Notebook $notebook)
    {
        $this->send_updateNotebook($authenticationToken, $notebook);
        return $this->recv_updateNotebook();
    }

    public function send_updateNotebook($authenticationToken, \EDAM\Types\Notebook $notebook)
    {
        $args = new \EDAM\NoteStore\NoteStore_updateNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $args->notebook = $notebook;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'updateNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('updateNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_updateNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_updateNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_updateNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("updateNotebook failed: unknown result");
    }

    public function expungeNotebook($authenticationToken, $guid)
    {
        $this->send_expungeNotebook($authenticationToken, $guid);
        return $this->recv_expungeNotebook();
    }

    public function send_expungeNotebook($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_expungeNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'expungeNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('expungeNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_expungeNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_expungeNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_expungeNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("expungeNotebook failed: unknown result");
    }

    public function listTags($authenticationToken)
    {
        $this->send_listTags($authenticationToken);
        return $this->recv_listTags();
    }

    public function send_listTags($authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_listTags_args();
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'listTags', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('listTags', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_listTags()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_listTags_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_listTags_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("listTags failed: unknown result");
    }

    public function listTagsByNotebook($authenticationToken, $notebookGuid)
    {
        $this->send_listTagsByNotebook($authenticationToken, $notebookGuid);
        return $this->recv_listTagsByNotebook();
    }

    public function send_listTagsByNotebook($authenticationToken, $notebookGuid)
    {
        $args = new \EDAM\NoteStore\NoteStore_listTagsByNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $args->notebookGuid = $notebookGuid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'listTagsByNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('listTagsByNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_listTagsByNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_listTagsByNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_listTagsByNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("listTagsByNotebook failed: unknown result");
    }

    public function getTag($authenticationToken, $guid)
    {
        $this->send_getTag($authenticationToken, $guid);
        return $this->recv_getTag();
    }

    public function send_getTag($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getTag_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getTag', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getTag', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getTag()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getTag_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getTag_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getTag failed: unknown result");
    }

    public function createTag($authenticationToken, \EDAM\Types\Tag $tag)
    {
        $this->send_createTag($authenticationToken, $tag);
        return $this->recv_createTag();
    }

    public function send_createTag($authenticationToken, \EDAM\Types\Tag $tag)
    {
        $args = new \EDAM\NoteStore\NoteStore_createTag_args();
        $args->authenticationToken = $authenticationToken;
        $args->tag = $tag;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'createTag', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('createTag', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_createTag()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_createTag_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_createTag_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("createTag failed: unknown result");
    }

    public function updateTag($authenticationToken, \EDAM\Types\Tag $tag)
    {
        $this->send_updateTag($authenticationToken, $tag);
        return $this->recv_updateTag();
    }

    public function send_updateTag($authenticationToken, \EDAM\Types\Tag $tag)
    {
        $args = new \EDAM\NoteStore\NoteStore_updateTag_args();
        $args->authenticationToken = $authenticationToken;
        $args->tag = $tag;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'updateTag', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('updateTag', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_updateTag()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_updateTag_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_updateTag_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("updateTag failed: unknown result");
    }

    public function untagAll($authenticationToken, $guid)
    {
        $this->send_untagAll($authenticationToken, $guid);
        $this->recv_untagAll();
    }

    public function send_untagAll($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_untagAll_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'untagAll', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('untagAll', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_untagAll()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_untagAll_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_untagAll_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        return;
    }

    public function expungeTag($authenticationToken, $guid)
    {
        $this->send_expungeTag($authenticationToken, $guid);
        return $this->recv_expungeTag();
    }

    public function send_expungeTag($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_expungeTag_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'expungeTag', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('expungeTag', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_expungeTag()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_expungeTag_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_expungeTag_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("expungeTag failed: unknown result");
    }

    public function listSearches($authenticationToken)
    {
        $this->send_listSearches($authenticationToken);
        return $this->recv_listSearches();
    }

    public function send_listSearches($authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_listSearches_args();
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'listSearches', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('listSearches', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_listSearches()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_listSearches_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_listSearches_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("listSearches failed: unknown result");
    }

    public function getSearch($authenticationToken, $guid)
    {
        $this->send_getSearch($authenticationToken, $guid);
        return $this->recv_getSearch();
    }

    public function send_getSearch($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getSearch_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getSearch', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getSearch', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getSearch()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getSearch_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getSearch_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getSearch failed: unknown result");
    }

    public function createSearch($authenticationToken, \EDAM\Types\SavedSearch $search)
    {
        $this->send_createSearch($authenticationToken, $search);
        return $this->recv_createSearch();
    }

    public function send_createSearch($authenticationToken, \EDAM\Types\SavedSearch $search)
    {
        $args = new \EDAM\NoteStore\NoteStore_createSearch_args();
        $args->authenticationToken = $authenticationToken;
        $args->search = $search;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'createSearch', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('createSearch', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_createSearch()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_createSearch_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_createSearch_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("createSearch failed: unknown result");
    }

    public function updateSearch($authenticationToken, \EDAM\Types\SavedSearch $search)
    {
        $this->send_updateSearch($authenticationToken, $search);
        return $this->recv_updateSearch();
    }

    public function send_updateSearch($authenticationToken, \EDAM\Types\SavedSearch $search)
    {
        $args = new \EDAM\NoteStore\NoteStore_updateSearch_args();
        $args->authenticationToken = $authenticationToken;
        $args->search = $search;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'updateSearch', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('updateSearch', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_updateSearch()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_updateSearch_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_updateSearch_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("updateSearch failed: unknown result");
    }

    public function expungeSearch($authenticationToken, $guid)
    {
        $this->send_expungeSearch($authenticationToken, $guid);
        return $this->recv_expungeSearch();
    }

    public function send_expungeSearch($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_expungeSearch_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'expungeSearch', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('expungeSearch', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_expungeSearch()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_expungeSearch_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_expungeSearch_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("expungeSearch failed: unknown result");
    }

    public function findNotes($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $offset, $maxNotes)
    {
        $this->send_findNotes($authenticationToken, $filter, $offset, $maxNotes);
        return $this->recv_findNotes();
    }

    public function send_findNotes($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $offset, $maxNotes)
    {
        $args = new \EDAM\NoteStore\NoteStore_findNotes_args();
        $args->authenticationToken = $authenticationToken;
        $args->filter = $filter;
        $args->offset = $offset;
        $args->maxNotes = $maxNotes;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'findNotes', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('findNotes', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_findNotes()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_findNotes_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_findNotes_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("findNotes failed: unknown result");
    }

    public function findNoteOffset($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $guid)
    {
        $this->send_findNoteOffset($authenticationToken, $filter, $guid);
        return $this->recv_findNoteOffset();
    }

    public function send_findNoteOffset($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_findNoteOffset_args();
        $args->authenticationToken = $authenticationToken;
        $args->filter = $filter;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'findNoteOffset', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('findNoteOffset', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_findNoteOffset()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_findNoteOffset_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_findNoteOffset_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("findNoteOffset failed: unknown result");
    }

    public function findNotesMetadata($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $offset, $maxNotes, \EDAM\NoteStore\NotesMetadataResultSpec $resultSpec)
    {
        $this->send_findNotesMetadata($authenticationToken, $filter, $offset, $maxNotes, $resultSpec);
        return $this->recv_findNotesMetadata();
    }

    public function send_findNotesMetadata($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $offset, $maxNotes, \EDAM\NoteStore\NotesMetadataResultSpec $resultSpec)
    {
        $args = new \EDAM\NoteStore\NoteStore_findNotesMetadata_args();
        $args->authenticationToken = $authenticationToken;
        $args->filter = $filter;
        $args->offset = $offset;
        $args->maxNotes = $maxNotes;
        $args->resultSpec = $resultSpec;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'findNotesMetadata', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('findNotesMetadata', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_findNotesMetadata()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_findNotesMetadata_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_findNotesMetadata_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("findNotesMetadata failed: unknown result");
    }

    public function findNoteCounts($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $withTrash)
    {
        $this->send_findNoteCounts($authenticationToken, $filter, $withTrash);
        return $this->recv_findNoteCounts();
    }

    public function send_findNoteCounts($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $withTrash)
    {
        $args = new \EDAM\NoteStore\NoteStore_findNoteCounts_args();
        $args->authenticationToken = $authenticationToken;
        $args->filter = $filter;
        $args->withTrash = $withTrash;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'findNoteCounts', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('findNoteCounts', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_findNoteCounts()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_findNoteCounts_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_findNoteCounts_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("findNoteCounts failed: unknown result");
    }

    public function getNote($authenticationToken, $guid, $withContent, $withResourcesData, $withResourcesRecognition, $withResourcesAlternateData)
    {
        $this->send_getNote($authenticationToken, $guid, $withContent, $withResourcesData, $withResourcesRecognition, $withResourcesAlternateData);
        return $this->recv_getNote();
    }

    public function send_getNote($authenticationToken, $guid, $withContent, $withResourcesData, $withResourcesRecognition, $withResourcesAlternateData)
    {
        $args = new \EDAM\NoteStore\NoteStore_getNote_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $args->withContent = $withContent;
        $args->withResourcesData = $withResourcesData;
        $args->withResourcesRecognition = $withResourcesRecognition;
        $args->withResourcesAlternateData = $withResourcesAlternateData;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getNote', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getNote', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getNote()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getNote_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getNote_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getNote failed: unknown result");
    }

    public function getNoteApplicationData($authenticationToken, $guid)
    {
        $this->send_getNoteApplicationData($authenticationToken, $guid);
        return $this->recv_getNoteApplicationData();
    }

    public function send_getNoteApplicationData($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getNoteApplicationData_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getNoteApplicationData', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getNoteApplicationData', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getNoteApplicationData()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getNoteApplicationData_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getNoteApplicationData_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getNoteApplicationData failed: unknown result");
    }

    public function getNoteApplicationDataEntry($authenticationToken, $guid, $key)
    {
        $this->send_getNoteApplicationDataEntry($authenticationToken, $guid, $key);
        return $this->recv_getNoteApplicationDataEntry();
    }

    public function send_getNoteApplicationDataEntry($authenticationToken, $guid, $key)
    {
        $args = new \EDAM\NoteStore\NoteStore_getNoteApplicationDataEntry_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $args->key = $key;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getNoteApplicationDataEntry', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getNoteApplicationDataEntry', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getNoteApplicationDataEntry()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getNoteApplicationDataEntry_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getNoteApplicationDataEntry_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getNoteApplicationDataEntry failed: unknown result");
    }

    public function setNoteApplicationDataEntry($authenticationToken, $guid, $key, $value)
    {
        $this->send_setNoteApplicationDataEntry($authenticationToken, $guid, $key, $value);
        return $this->recv_setNoteApplicationDataEntry();
    }

    public function send_setNoteApplicationDataEntry($authenticationToken, $guid, $key, $value)
    {
        $args = new \EDAM\NoteStore\NoteStore_setNoteApplicationDataEntry_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $args->key = $key;
        $args->value = $value;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'setNoteApplicationDataEntry', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('setNoteApplicationDataEntry', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_setNoteApplicationDataEntry()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_setNoteApplicationDataEntry_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_setNoteApplicationDataEntry_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("setNoteApplicationDataEntry failed: unknown result");
    }

    public function unsetNoteApplicationDataEntry($authenticationToken, $guid, $key)
    {
        $this->send_unsetNoteApplicationDataEntry($authenticationToken, $guid, $key);
        return $this->recv_unsetNoteApplicationDataEntry();
    }

    public function send_unsetNoteApplicationDataEntry($authenticationToken, $guid, $key)
    {
        $args = new \EDAM\NoteStore\NoteStore_unsetNoteApplicationDataEntry_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $args->key = $key;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'unsetNoteApplicationDataEntry', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('unsetNoteApplicationDataEntry', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_unsetNoteApplicationDataEntry()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_unsetNoteApplicationDataEntry_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_unsetNoteApplicationDataEntry_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("unsetNoteApplicationDataEntry failed: unknown result");
    }

    public function getNoteContent($authenticationToken, $guid)
    {
        $this->send_getNoteContent($authenticationToken, $guid);
        return $this->recv_getNoteContent();
    }

    public function send_getNoteContent($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getNoteContent_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getNoteContent', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getNoteContent', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getNoteContent()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getNoteContent_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getNoteContent_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getNoteContent failed: unknown result");
    }

    public function getNoteSearchText($authenticationToken, $guid, $noteOnly, $tokenizeForIndexing)
    {
        $this->send_getNoteSearchText($authenticationToken, $guid, $noteOnly, $tokenizeForIndexing);
        return $this->recv_getNoteSearchText();
    }

    public function send_getNoteSearchText($authenticationToken, $guid, $noteOnly, $tokenizeForIndexing)
    {
        $args = new \EDAM\NoteStore\NoteStore_getNoteSearchText_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $args->noteOnly = $noteOnly;
        $args->tokenizeForIndexing = $tokenizeForIndexing;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getNoteSearchText', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getNoteSearchText', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getNoteSearchText()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getNoteSearchText_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getNoteSearchText_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getNoteSearchText failed: unknown result");
    }

    public function getResourceSearchText($authenticationToken, $guid)
    {
        $this->send_getResourceSearchText($authenticationToken, $guid);
        return $this->recv_getResourceSearchText();
    }

    public function send_getResourceSearchText($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getResourceSearchText_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getResourceSearchText', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getResourceSearchText', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getResourceSearchText()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getResourceSearchText_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getResourceSearchText_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getResourceSearchText failed: unknown result");
    }

    public function getNoteTagNames($authenticationToken, $guid)
    {
        $this->send_getNoteTagNames($authenticationToken, $guid);
        return $this->recv_getNoteTagNames();
    }

    public function send_getNoteTagNames($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getNoteTagNames_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getNoteTagNames', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getNoteTagNames', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getNoteTagNames()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getNoteTagNames_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getNoteTagNames_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getNoteTagNames failed: unknown result");
    }

    public function createNote($authenticationToken, \EDAM\Types\Note $note)
    {
        $this->send_createNote($authenticationToken, $note);
        return $this->recv_createNote();
    }

    public function send_createNote($authenticationToken, \EDAM\Types\Note $note)
    {
        $args = new \EDAM\NoteStore\NoteStore_createNote_args();
        $args->authenticationToken = $authenticationToken;
        $args->note = $note;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'createNote', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('createNote', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_createNote()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_createNote_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_createNote_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("createNote failed: unknown result");
    }

    public function updateNote($authenticationToken, \EDAM\Types\Note $note)
    {
        $this->send_updateNote($authenticationToken, $note);
        return $this->recv_updateNote();
    }

    public function send_updateNote($authenticationToken, \EDAM\Types\Note $note)
    {
        $args = new \EDAM\NoteStore\NoteStore_updateNote_args();
        $args->authenticationToken = $authenticationToken;
        $args->note = $note;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'updateNote', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('updateNote', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_updateNote()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_updateNote_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_updateNote_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("updateNote failed: unknown result");
    }

    public function deleteNote($authenticationToken, $guid)
    {
        $this->send_deleteNote($authenticationToken, $guid);
        return $this->recv_deleteNote();
    }

    public function send_deleteNote($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_deleteNote_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'deleteNote', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('deleteNote', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_deleteNote()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_deleteNote_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_deleteNote_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("deleteNote failed: unknown result");
    }

    public function expungeNote($authenticationToken, $guid)
    {
        $this->send_expungeNote($authenticationToken, $guid);
        return $this->recv_expungeNote();
    }

    public function send_expungeNote($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_expungeNote_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'expungeNote', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('expungeNote', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_expungeNote()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_expungeNote_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_expungeNote_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("expungeNote failed: unknown result");
    }

    public function expungeNotes($authenticationToken, $noteGuids)
    {
        $this->send_expungeNotes($authenticationToken, $noteGuids);
        return $this->recv_expungeNotes();
    }

    public function send_expungeNotes($authenticationToken, $noteGuids)
    {
        $args = new \EDAM\NoteStore\NoteStore_expungeNotes_args();
        $args->authenticationToken = $authenticationToken;
        $args->noteGuids = $noteGuids;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'expungeNotes', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('expungeNotes', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_expungeNotes()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_expungeNotes_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_expungeNotes_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("expungeNotes failed: unknown result");
    }

    public function expungeInactiveNotes($authenticationToken)
    {
        $this->send_expungeInactiveNotes($authenticationToken);
        return $this->recv_expungeInactiveNotes();
    }

    public function send_expungeInactiveNotes($authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_expungeInactiveNotes_args();
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'expungeInactiveNotes', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('expungeInactiveNotes', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_expungeInactiveNotes()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_expungeInactiveNotes_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_expungeInactiveNotes_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("expungeInactiveNotes failed: unknown result");
    }

    public function copyNote($authenticationToken, $noteGuid, $toNotebookGuid)
    {
        $this->send_copyNote($authenticationToken, $noteGuid, $toNotebookGuid);
        return $this->recv_copyNote();
    }

    public function send_copyNote($authenticationToken, $noteGuid, $toNotebookGuid)
    {
        $args = new \EDAM\NoteStore\NoteStore_copyNote_args();
        $args->authenticationToken = $authenticationToken;
        $args->noteGuid = $noteGuid;
        $args->toNotebookGuid = $toNotebookGuid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'copyNote', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('copyNote', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_copyNote()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_copyNote_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_copyNote_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("copyNote failed: unknown result");
    }

    public function listNoteVersions($authenticationToken, $noteGuid)
    {
        $this->send_listNoteVersions($authenticationToken, $noteGuid);
        return $this->recv_listNoteVersions();
    }

    public function send_listNoteVersions($authenticationToken, $noteGuid)
    {
        $args = new \EDAM\NoteStore\NoteStore_listNoteVersions_args();
        $args->authenticationToken = $authenticationToken;
        $args->noteGuid = $noteGuid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'listNoteVersions', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('listNoteVersions', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_listNoteVersions()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_listNoteVersions_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_listNoteVersions_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("listNoteVersions failed: unknown result");
    }

    public function getNoteVersion($authenticationToken, $noteGuid, $updateSequenceNum, $withResourcesData, $withResourcesRecognition, $withResourcesAlternateData)
    {
        $this->send_getNoteVersion($authenticationToken, $noteGuid, $updateSequenceNum, $withResourcesData, $withResourcesRecognition, $withResourcesAlternateData);
        return $this->recv_getNoteVersion();
    }

    public function send_getNoteVersion($authenticationToken, $noteGuid, $updateSequenceNum, $withResourcesData, $withResourcesRecognition, $withResourcesAlternateData)
    {
        $args = new \EDAM\NoteStore\NoteStore_getNoteVersion_args();
        $args->authenticationToken = $authenticationToken;
        $args->noteGuid = $noteGuid;
        $args->updateSequenceNum = $updateSequenceNum;
        $args->withResourcesData = $withResourcesData;
        $args->withResourcesRecognition = $withResourcesRecognition;
        $args->withResourcesAlternateData = $withResourcesAlternateData;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getNoteVersion', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getNoteVersion', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getNoteVersion()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getNoteVersion_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getNoteVersion_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getNoteVersion failed: unknown result");
    }

    public function getResource($authenticationToken, $guid, $withData, $withRecognition, $withAttributes, $withAlternateData)
    {
        $this->send_getResource($authenticationToken, $guid, $withData, $withRecognition, $withAttributes, $withAlternateData);
        return $this->recv_getResource();
    }

    public function send_getResource($authenticationToken, $guid, $withData, $withRecognition, $withAttributes, $withAlternateData)
    {
        $args = new \EDAM\NoteStore\NoteStore_getResource_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $args->withData = $withData;
        $args->withRecognition = $withRecognition;
        $args->withAttributes = $withAttributes;
        $args->withAlternateData = $withAlternateData;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getResource', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getResource', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getResource()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getResource_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getResource_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getResource failed: unknown result");
    }

    public function getResourceApplicationData($authenticationToken, $guid)
    {
        $this->send_getResourceApplicationData($authenticationToken, $guid);
        return $this->recv_getResourceApplicationData();
    }

    public function send_getResourceApplicationData($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getResourceApplicationData_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getResourceApplicationData', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getResourceApplicationData', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getResourceApplicationData()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getResourceApplicationData_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getResourceApplicationData_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getResourceApplicationData failed: unknown result");
    }

    public function getResourceApplicationDataEntry($authenticationToken, $guid, $key)
    {
        $this->send_getResourceApplicationDataEntry($authenticationToken, $guid, $key);
        return $this->recv_getResourceApplicationDataEntry();
    }

    public function send_getResourceApplicationDataEntry($authenticationToken, $guid, $key)
    {
        $args = new \EDAM\NoteStore\NoteStore_getResourceApplicationDataEntry_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $args->key = $key;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getResourceApplicationDataEntry', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getResourceApplicationDataEntry', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getResourceApplicationDataEntry()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getResourceApplicationDataEntry_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getResourceApplicationDataEntry_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getResourceApplicationDataEntry failed: unknown result");
    }

    public function setResourceApplicationDataEntry($authenticationToken, $guid, $key, $value)
    {
        $this->send_setResourceApplicationDataEntry($authenticationToken, $guid, $key, $value);
        return $this->recv_setResourceApplicationDataEntry();
    }

    public function send_setResourceApplicationDataEntry($authenticationToken, $guid, $key, $value)
    {
        $args = new \EDAM\NoteStore\NoteStore_setResourceApplicationDataEntry_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $args->key = $key;
        $args->value = $value;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'setResourceApplicationDataEntry', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('setResourceApplicationDataEntry', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_setResourceApplicationDataEntry()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_setResourceApplicationDataEntry_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_setResourceApplicationDataEntry_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("setResourceApplicationDataEntry failed: unknown result");
    }

    public function unsetResourceApplicationDataEntry($authenticationToken, $guid, $key)
    {
        $this->send_unsetResourceApplicationDataEntry($authenticationToken, $guid, $key);
        return $this->recv_unsetResourceApplicationDataEntry();
    }

    public function send_unsetResourceApplicationDataEntry($authenticationToken, $guid, $key)
    {
        $args = new \EDAM\NoteStore\NoteStore_unsetResourceApplicationDataEntry_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $args->key = $key;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'unsetResourceApplicationDataEntry', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('unsetResourceApplicationDataEntry', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_unsetResourceApplicationDataEntry()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_unsetResourceApplicationDataEntry_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_unsetResourceApplicationDataEntry_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("unsetResourceApplicationDataEntry failed: unknown result");
    }

    public function updateResource($authenticationToken, \EDAM\Types\Resource $resource)
    {
        $this->send_updateResource($authenticationToken, $resource);
        return $this->recv_updateResource();
    }

    public function send_updateResource($authenticationToken, \EDAM\Types\Resource $resource)
    {
        $args = new \EDAM\NoteStore\NoteStore_updateResource_args();
        $args->authenticationToken = $authenticationToken;
        $args->resource = $resource;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'updateResource', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('updateResource', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_updateResource()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_updateResource_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_updateResource_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("updateResource failed: unknown result");
    }

    public function getResourceData($authenticationToken, $guid)
    {
        $this->send_getResourceData($authenticationToken, $guid);
        return $this->recv_getResourceData();
    }

    public function send_getResourceData($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getResourceData_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getResourceData', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getResourceData', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getResourceData()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getResourceData_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getResourceData_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getResourceData failed: unknown result");
    }

    public function getResourceByHash($authenticationToken, $noteGuid, $contentHash, $withData, $withRecognition, $withAlternateData)
    {
        $this->send_getResourceByHash($authenticationToken, $noteGuid, $contentHash, $withData, $withRecognition, $withAlternateData);
        return $this->recv_getResourceByHash();
    }

    public function send_getResourceByHash($authenticationToken, $noteGuid, $contentHash, $withData, $withRecognition, $withAlternateData)
    {
        $args = new \EDAM\NoteStore\NoteStore_getResourceByHash_args();
        $args->authenticationToken = $authenticationToken;
        $args->noteGuid = $noteGuid;
        $args->contentHash = $contentHash;
        $args->withData = $withData;
        $args->withRecognition = $withRecognition;
        $args->withAlternateData = $withAlternateData;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getResourceByHash', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getResourceByHash', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getResourceByHash()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getResourceByHash_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getResourceByHash_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getResourceByHash failed: unknown result");
    }

    public function getResourceRecognition($authenticationToken, $guid)
    {
        $this->send_getResourceRecognition($authenticationToken, $guid);
        return $this->recv_getResourceRecognition();
    }

    public function send_getResourceRecognition($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getResourceRecognition_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getResourceRecognition', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getResourceRecognition', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getResourceRecognition()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getResourceRecognition_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getResourceRecognition_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getResourceRecognition failed: unknown result");
    }

    public function getResourceAlternateData($authenticationToken, $guid)
    {
        $this->send_getResourceAlternateData($authenticationToken, $guid);
        return $this->recv_getResourceAlternateData();
    }

    public function send_getResourceAlternateData($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getResourceAlternateData_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getResourceAlternateData', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getResourceAlternateData', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getResourceAlternateData()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getResourceAlternateData_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getResourceAlternateData_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getResourceAlternateData failed: unknown result");
    }

    public function getResourceAttributes($authenticationToken, $guid)
    {
        $this->send_getResourceAttributes($authenticationToken, $guid);
        return $this->recv_getResourceAttributes();
    }

    public function send_getResourceAttributes($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_getResourceAttributes_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getResourceAttributes', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getResourceAttributes', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getResourceAttributes()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getResourceAttributes_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getResourceAttributes_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getResourceAttributes failed: unknown result");
    }

    public function getPublicNotebook($userId, $publicUri)
    {
        $this->send_getPublicNotebook($userId, $publicUri);
        return $this->recv_getPublicNotebook();
    }

    public function send_getPublicNotebook($userId, $publicUri)
    {
        $args = new \EDAM\NoteStore\NoteStore_getPublicNotebook_args();
        $args->userId = $userId;
        $args->publicUri = $publicUri;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getPublicNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getPublicNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getPublicNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getPublicNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getPublicNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("getPublicNotebook failed: unknown result");
    }

    public function createSharedNotebook($authenticationToken, \EDAM\Types\SharedNotebook $sharedNotebook)
    {
        $this->send_createSharedNotebook($authenticationToken, $sharedNotebook);
        return $this->recv_createSharedNotebook();
    }

    public function send_createSharedNotebook($authenticationToken, \EDAM\Types\SharedNotebook $sharedNotebook)
    {
        $args = new \EDAM\NoteStore\NoteStore_createSharedNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $args->sharedNotebook = $sharedNotebook;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'createSharedNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('createSharedNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_createSharedNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_createSharedNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_createSharedNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("createSharedNotebook failed: unknown result");
    }

    public function updateSharedNotebook($authenticationToken, \EDAM\Types\SharedNotebook $sharedNotebook)
    {
        $this->send_updateSharedNotebook($authenticationToken, $sharedNotebook);
        return $this->recv_updateSharedNotebook();
    }

    public function send_updateSharedNotebook($authenticationToken, \EDAM\Types\SharedNotebook $sharedNotebook)
    {
        $args = new \EDAM\NoteStore\NoteStore_updateSharedNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $args->sharedNotebook = $sharedNotebook;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'updateSharedNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('updateSharedNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_updateSharedNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_updateSharedNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_updateSharedNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("updateSharedNotebook failed: unknown result");
    }

    public function setSharedNotebookRecipientSettings($authenticationToken, $sharedNotebookId, \EDAM\Types\SharedNotebookRecipientSettings $recipientSettings)
    {
        $this->send_setSharedNotebookRecipientSettings($authenticationToken, $sharedNotebookId, $recipientSettings);
        return $this->recv_setSharedNotebookRecipientSettings();
    }

    public function send_setSharedNotebookRecipientSettings($authenticationToken, $sharedNotebookId, \EDAM\Types\SharedNotebookRecipientSettings $recipientSettings)
    {
        $args = new \EDAM\NoteStore\NoteStore_setSharedNotebookRecipientSettings_args();
        $args->authenticationToken = $authenticationToken;
        $args->sharedNotebookId = $sharedNotebookId;
        $args->recipientSettings = $recipientSettings;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'setSharedNotebookRecipientSettings', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('setSharedNotebookRecipientSettings', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_setSharedNotebookRecipientSettings()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_setSharedNotebookRecipientSettings_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_setSharedNotebookRecipientSettings_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("setSharedNotebookRecipientSettings failed: unknown result");
    }

    public function sendMessageToSharedNotebookMembers($authenticationToken, $notebookGuid, $messageText, $recipients)
    {
        $this->send_sendMessageToSharedNotebookMembers($authenticationToken, $notebookGuid, $messageText, $recipients);
        return $this->recv_sendMessageToSharedNotebookMembers();
    }

    public function send_sendMessageToSharedNotebookMembers($authenticationToken, $notebookGuid, $messageText, $recipients)
    {
        $args = new \EDAM\NoteStore\NoteStore_sendMessageToSharedNotebookMembers_args();
        $args->authenticationToken = $authenticationToken;
        $args->notebookGuid = $notebookGuid;
        $args->messageText = $messageText;
        $args->recipients = $recipients;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'sendMessageToSharedNotebookMembers', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('sendMessageToSharedNotebookMembers', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_sendMessageToSharedNotebookMembers()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_sendMessageToSharedNotebookMembers_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_sendMessageToSharedNotebookMembers_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("sendMessageToSharedNotebookMembers failed: unknown result");
    }

    public function listSharedNotebooks($authenticationToken)
    {
        $this->send_listSharedNotebooks($authenticationToken);
        return $this->recv_listSharedNotebooks();
    }

    public function send_listSharedNotebooks($authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_listSharedNotebooks_args();
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'listSharedNotebooks', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('listSharedNotebooks', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_listSharedNotebooks()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_listSharedNotebooks_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_listSharedNotebooks_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("listSharedNotebooks failed: unknown result");
    }

    public function expungeSharedNotebooks($authenticationToken, $sharedNotebookIds)
    {
        $this->send_expungeSharedNotebooks($authenticationToken, $sharedNotebookIds);
        return $this->recv_expungeSharedNotebooks();
    }

    public function send_expungeSharedNotebooks($authenticationToken, $sharedNotebookIds)
    {
        $args = new \EDAM\NoteStore\NoteStore_expungeSharedNotebooks_args();
        $args->authenticationToken = $authenticationToken;
        $args->sharedNotebookIds = $sharedNotebookIds;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'expungeSharedNotebooks', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('expungeSharedNotebooks', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_expungeSharedNotebooks()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_expungeSharedNotebooks_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_expungeSharedNotebooks_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("expungeSharedNotebooks failed: unknown result");
    }

    public function createLinkedNotebook($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook)
    {
        $this->send_createLinkedNotebook($authenticationToken, $linkedNotebook);
        return $this->recv_createLinkedNotebook();
    }

    public function send_createLinkedNotebook($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook)
    {
        $args = new \EDAM\NoteStore\NoteStore_createLinkedNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $args->linkedNotebook = $linkedNotebook;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'createLinkedNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('createLinkedNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_createLinkedNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_createLinkedNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_createLinkedNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("createLinkedNotebook failed: unknown result");
    }

    public function updateLinkedNotebook($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook)
    {
        $this->send_updateLinkedNotebook($authenticationToken, $linkedNotebook);
        return $this->recv_updateLinkedNotebook();
    }

    public function send_updateLinkedNotebook($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook)
    {
        $args = new \EDAM\NoteStore\NoteStore_updateLinkedNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $args->linkedNotebook = $linkedNotebook;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'updateLinkedNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('updateLinkedNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_updateLinkedNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_updateLinkedNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_updateLinkedNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("updateLinkedNotebook failed: unknown result");
    }

    public function listLinkedNotebooks($authenticationToken)
    {
        $this->send_listLinkedNotebooks($authenticationToken);
        return $this->recv_listLinkedNotebooks();
    }

    public function send_listLinkedNotebooks($authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_listLinkedNotebooks_args();
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'listLinkedNotebooks', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('listLinkedNotebooks', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_listLinkedNotebooks()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_listLinkedNotebooks_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_listLinkedNotebooks_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("listLinkedNotebooks failed: unknown result");
    }

    public function expungeLinkedNotebook($authenticationToken, $guid)
    {
        $this->send_expungeLinkedNotebook($authenticationToken, $guid);
        return $this->recv_expungeLinkedNotebook();
    }

    public function send_expungeLinkedNotebook($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_expungeLinkedNotebook_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'expungeLinkedNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('expungeLinkedNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_expungeLinkedNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_expungeLinkedNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_expungeLinkedNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("expungeLinkedNotebook failed: unknown result");
    }

    public function authenticateToSharedNotebook($shareKey, $authenticationToken)
    {
        $this->send_authenticateToSharedNotebook($shareKey, $authenticationToken);
        return $this->recv_authenticateToSharedNotebook();
    }

    public function send_authenticateToSharedNotebook($shareKey, $authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_authenticateToSharedNotebook_args();
        $args->shareKey = $shareKey;
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'authenticateToSharedNotebook', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('authenticateToSharedNotebook', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_authenticateToSharedNotebook()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_authenticateToSharedNotebook_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_authenticateToSharedNotebook_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("authenticateToSharedNotebook failed: unknown result");
    }

    public function getSharedNotebookByAuth($authenticationToken)
    {
        $this->send_getSharedNotebookByAuth($authenticationToken);
        return $this->recv_getSharedNotebookByAuth();
    }

    public function send_getSharedNotebookByAuth($authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_getSharedNotebookByAuth_args();
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'getSharedNotebookByAuth', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('getSharedNotebookByAuth', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_getSharedNotebookByAuth()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_getSharedNotebookByAuth_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_getSharedNotebookByAuth_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("getSharedNotebookByAuth failed: unknown result");
    }

    public function emailNote($authenticationToken, \EDAM\NoteStore\NoteEmailParameters $parameters)
    {
        $this->send_emailNote($authenticationToken, $parameters);
        $this->recv_emailNote();
    }

    public function send_emailNote($authenticationToken, \EDAM\NoteStore\NoteEmailParameters $parameters)
    {
        $args = new \EDAM\NoteStore\NoteStore_emailNote_args();
        $args->authenticationToken = $authenticationToken;
        $args->parameters = $parameters;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'emailNote', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('emailNote', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_emailNote()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_emailNote_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_emailNote_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        return;
    }

    public function shareNote($authenticationToken, $guid)
    {
        $this->send_shareNote($authenticationToken, $guid);
        return $this->recv_shareNote();
    }

    public function send_shareNote($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_shareNote_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'shareNote', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('shareNote', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_shareNote()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_shareNote_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_shareNote_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("shareNote failed: unknown result");
    }

    public function stopSharingNote($authenticationToken, $guid)
    {
        $this->send_stopSharingNote($authenticationToken, $guid);
        $this->recv_stopSharingNote();
    }

    public function send_stopSharingNote($authenticationToken, $guid)
    {
        $args = new \EDAM\NoteStore\NoteStore_stopSharingNote_args();
        $args->authenticationToken = $authenticationToken;
        $args->guid = $guid;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'stopSharingNote', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('stopSharingNote', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_stopSharingNote()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_stopSharingNote_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_stopSharingNote_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        return;
    }

    public function authenticateToSharedNote($guid, $noteKey, $authenticationToken)
    {
        $this->send_authenticateToSharedNote($guid, $noteKey, $authenticationToken);
        return $this->recv_authenticateToSharedNote();
    }

    public function send_authenticateToSharedNote($guid, $noteKey, $authenticationToken)
    {
        $args = new \EDAM\NoteStore\NoteStore_authenticateToSharedNote_args();
        $args->guid = $guid;
        $args->noteKey = $noteKey;
        $args->authenticationToken = $authenticationToken;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'authenticateToSharedNote', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('authenticateToSharedNote', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_authenticateToSharedNote()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_authenticateToSharedNote_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_authenticateToSharedNote_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        throw new \Exception("authenticateToSharedNote failed: unknown result");
    }

    public function findRelated($authenticationToken, \EDAM\NoteStore\RelatedQuery $query, \EDAM\NoteStore\RelatedResultSpec $resultSpec)
    {
        $this->send_findRelated($authenticationToken, $query, $resultSpec);
        return $this->recv_findRelated();
    }

    public function send_findRelated($authenticationToken, \EDAM\NoteStore\RelatedQuery $query, \EDAM\NoteStore\RelatedResultSpec $resultSpec)
    {
        $args = new \EDAM\NoteStore\NoteStore_findRelated_args();
        $args->authenticationToken = $authenticationToken;
        $args->query = $query;
        $args->resultSpec = $resultSpec;
        $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
        if ($bin_accel)
        {
            thrift_protocol_write_binary($this->output_, 'findRelated', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
        }
        else
        {
            $this->output_->writeMessageBegin('findRelated', TMessageType::CALL, $this->seqid_);
            $args->write($this->output_);
            $this->output_->writeMessageEnd();
            $this->output_->getTransport()->flush();
        }
    }

    public function recv_findRelated()
    {
        $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
        if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\EDAM\NoteStore\NoteStore_findRelated_result', $this->input_->isStrictRead());
        else
        {
            $rseqid = 0;
            $fname = null;
            $mtype = 0;

            $this->input_->readMessageBegin($fname, $mtype, $rseqid);
            if ($mtype == TMessageType::EXCEPTION) {
                $x = new TApplicationException();
                $x->read($this->input_);
                $this->input_->readMessageEnd();
                throw $x;
            }
            $result = new \EDAM\NoteStore\NoteStore_findRelated_result();
            $result->read($this->input_);
            $this->input_->readMessageEnd();
        }
        if ($result->success !== null) {
            return $result->success;
        }
        if ($result->userException !== null) {
            throw $result->userException;
        }
        if ($result->systemException !== null) {
            throw $result->systemException;
        }
        if ($result->notFoundException !== null) {
            throw $result->notFoundException;
        }
        throw new \Exception("findRelated failed: unknown result");
    }

}